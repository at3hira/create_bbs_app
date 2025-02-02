<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Category;
use App\Tag;
use Redis;
use UtilityService;

class ThreadsController extends Controller
{
	/**
	 * スレッド一覧ページ
	 * @param object $request
	 * @return object $thread
	 * @return boolean $device
	 * @return object $tags
	 */
	public function index(Request $request)
	{
		$threads = Thread::threadList()->paginate(10); // スレッド一覧取得(10件)
		// User-Agentを用いてデバイス判定
		$user_agent = $request->header('User-Agent');
		$device = UtilityService::judge_device($user_agent);

		foreach ($threads as $thread) {
			$body = str_replace(array("\r\n", "\r", "\n"), ' ', $thread->body);
			$thread->body = strip_tags($body);
		}

		// サイドメニューに表示するタグを全件取得
		$tags = UtilityService::all_tag_list();

		//$news_list = json_decode(Redis::command('get', ['news_list']));
		//$news_link = json_decode(Redis::command('get', ['news_link']));

		$params = [
			'threads' => $threads,
			'device'  => $device,
			'tags'    => $tags,
		];
		return view('threads.index', $params);
	}

	/**
	 * スレッド作成画面
	 */
	public function create()
	{
		$categorys = Category::where('status', 1)
		->orderBy('id', 'asc')
		->get();

		return view('threads.create', ['categorys' => $categorys]);
	}

	/**
	 * スレッド作成
	 * 
	 * @param object: $request
	 */
	public function store(Request $request)
	{
		$params = $request->validate([
			'title'       => 'required|max:50',
			'body'        => 'required|max:2000',
			'category_id' => 'required|integer',
			'image'       => 'required|file|image|mimes:jpeg,png,jpg,gif|max:8192',
			'tweet_tags'  => 'max:6000',
			'sub_title'   => 'required|max:50',
		]);

		// カテゴリデータチェック
		$category_data = Category::find($params['category_id']);
		if (empty($category_data->id)) {
			return back()->withInput();
		}
		$new_thr_id = Thread::max('id') + 1;
		//サムネ画像保存
		$params['img_url'] = UtilityService::save_thumbnail($new_thr_id, $params['image']);
		unset($params['image']);

		$data = Thread::create($params); //threadsテーブルにデータ登録

		// タグ登録
		$tags_id = UtilityService::add_tags_data($request->tags, $data);

		$thread = Thread::find($data->id); //$data->id : 作成したスレッドのid

		// attachメソッドで中間テーブルにデータ登録
		$thread->tags()->attach($tags_id);

		return redirect()->route('threads.index');
	}

	/**
	 * スレッド詳細ページ
	 * 
	 * @param string $thread_id
	 * @return object $thread
	 * @return object $tags
	 */
	public function show($thread_id)
	{
		$thread = Thread::findOrFail($thread_id);
		$tags = UtilityService::all_tag_list();	// サイドメニューに表示するタグを全件取得

		return view('threads.show', [
			'thread' => $thread,
			'tags' => $tags,
		]);
	}

	/**
	 * スレッド編集ページ
	 * 
	 * @param string $thread_id
	 * @return object $thread 
	 * @return string $tags スレッドに紐づいてるタグ
	 * @return object $categorys
	 */
	public function edit($thread_id) 
	{
		$thread = Thread::findOrFail($thread_id);

		// スレッドのインスタンスオブジェクトから中間テーブルを通して紐づくタグデータを取得
		$tagsData = $thread->tags()->orderby('tag_id')->get();
		$tagName = [];
		foreach($tagsData as $tag) {
			$tagName[] = $tag->name;
		}
		$tags = implode(',', $tagName);

		// Eloquentでカテゴリーデータを取得
		$categorys = Category::where('status', 1)
							->orderBy('id', 'asc')
							->get();

		return view('threads.edit', [
			'thread'    => $thread,
			'tags'      => $tags,
			'categorys' => $categorys,
		]);
	}

	/**
	 * 更新、削除のハンドリング
	 * edit.bladeテンプレートでSubmitボタンを複数置いた時のハンドリング
	 * 
	 * @param string $thread_id
	 * @param object $request
	 */
	public function post_process($thread_id, Request $request)
	{
		if ($request->input('update')) {
			// 更新処理
			$this->update($thread_id, $request);
			return redirect()->route('threads.show', ['id' => $thread_id]);
		} elseif($request->input('delete')) {
			// 論理削除
			$this->softDelete($thread_id);
			return redirect('/');
		}
	}

	/** 
	 * スレッド更新
	 * 
	 * @param string $thread_id 
	 * @param object $request
	 * 
	 * */
	public function update($thread_id, $request)
	{
		$params = $request->validate([
			'title'       => 'required|max:50',
			'body'        => 'required|max:2000',
			'category_id' => 'required|integer',
			'image'       => 'file|image|mimes:jpeg,png,jpg,gif|max:8192',
			'tweet_tags'  => 'max:6000',
			'sub_title'   => 'required|max:50',
		]);

		// カテゴリチェック
		$category_data = Category::find($params['category_id']);
		if (empty($category_data->id)) {
			return back()->withInput();
		}

		// サムネイル画像変更
		if (!empty($params["image"])) {
			UtilityService::save_thumbnail($thread_id, $params['image']);
			unset($params['image']);
		}
		$thread = Thread::findOrFail($thread_id);

		// タグ登録
		$tags_id = UtilityService::add_tags_data($request->tags, $thread);
		// 中間テーブルの更新
		$thread->tags()->sync($tags_id);

		$thread->fill($params)->save();
	}

	/**
	 * スレッド論理削除
	 * 
	 * @param string $thread_id
	 */
	public function softDelete($thread_id) 
	{
		$thread = Thread::find($thread_id);
		$thread->delete();
	}

	/**
	 * 選択されたタグを含んでいるスレッドを返却
	 * 
	 * @param object $request
	 * @param int $tag_id 選択されたタグid
	 */
	public function tag_search(Request $request, int $tag_id) 
	{
		// タグのインスタンス取得
		$tag_data = Tag::findOrFail($tag_id);
		// タグに対応するスレッドを全取得
		$threads = $tag_data->threads()->orderby('thread_id', 'desc')->paginate(10);
		// ユーザーエージェントでデバイス判定
		$user_agent = $request->header('User-Agent');
		$device = UtilityService::judge_device($user_agent);

		foreach($threads as $thread) {
			// 各スレッドに関連するタグを取得
			UtilityService::get_tags($thread);
		}

		// タグを全件取得
		$tags = UtilityService::all_tag_list();

		$params = [
			'threads'  => $threads,
			'device'   => $device,
			'tag_data' => $tag_data,
			'tags'     => $tags,
		];
		return view('threads.index', $params);
	}

	/**
	 * キーワード検索
	 * 
	 * 入力されたキーワードを含むスレッドを抽出
	 * 対象はtitle, bodyカラム
	 * 
	 * @param object $request
	 */
	public function keyword_search(Request $request) 
	{
		$keyword = $request->input('keyword');
		$query = Thread::query();
		// キーワードを含むスレッドを抽出
		$datas = UtilityService::searchKeyword($query, $keyword);
		$threads = $datas->orderBy('created_at', 'desc')->paginate(10);

		// ユーザーエージェントでデバイス判定
		$user_agent = $request->header('User-Agent');
		$device = UtilityService::judge_device($user_agent);
		// タグを全件取得
		$tags = UtilityService::all_tag_list();

		$params = [
			'threads' => $threads,
			'device'  => $device,
			'tags'    => $tags,
			'keyword' => $keyword,
		];
		return view('threads.keyword_search', $params);
	}
}
