<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Category;
use App\Tag;
use Redis;

class ThreadsController extends Controller
{
	/**
	 * スレッド一覧ページfunction
	 * @param object $request
	 * @return array $params スレッドデータ、デバイス判定
	 */
	public function index(Request $request)
	{
		// スレッドデータ10件取得
		$threads = Thread::threadList()->paginate(10);
		// User-Agentを用いてデバイス判定
		$user_agent = $request->header('User-Agent');
		$device = \UtilityService::judge_device($user_agent);

		foreach ($threads as $thread) {
			$body = str_replace(array("\r\n", "\r", "\n"), ' ', $thread->body);
			$thread->body = strip_tags($body);
		}


		//$news_list = json_decode(Redis::command('get', ['news_list']));
		//$news_link = json_decode(Redis::command('get', ['news_link']));

		$params = [
			'threads' => $threads,
			'device' => $device,
		];
		return view('threads.index', $params);
	}

	public function create()
	{
		return view('threads.create');
	}

	/**
	 * フォームからPOSTされたデータを基にスレッド新規作成
	 * 
	 * @param object: $request
	 */
	public function store(Request $request)
	{
		$params = $request->validate([
			'title' => 'required|max:50',
			'body' => 'required|max:2000',
			'category_id' => 'required|integer',
			'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:8192',
			'tweet_tags' => 'max:6000',
			'sub_title' => 'required|max:50',
		]);

		// カテゴリデータチェック
		$category_data = Category::find($params['category_id']);
		if (empty($category_data->id)) {
			return back()->withInput();
		}
		$new_thr_id = Thread::max('id') + 1;
		//サムネ画像保存
		$params['img_url'] = \UtilityService::save_thumbnail($new_thr_id, $params['image']);
		unset($params['image']);

		$data = Thread::create($params); //DBにデータ保存

		// タグ登録
		\UtilityService::add_tags_data($request->tags, $data);

		return redirect()->route('top');
	}

	public function show($thread_id)
	{
		$thread = Thread::findOrFail($thread_id);
		// スレッドに紐づいているタグを取得
		$threads = \UtilityService::get_tags($thread);

		return view('threads.show', [
			'thread' => $thread,
		]);
	}

	public function edit($thread_id) 
	{
		$thread = Thread::findOrFail($thread_id);

		$tagsData = $thread->tags()->orderby('tag_id')->get();	// スレッドのインスタンスオブジェクトから中間テーブルを通して紐づくタグデータを取得
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
			'thread' => $thread,
			'tags' => $tags,
			'categorys' => $categorys,
		]);
	}

	// スレッド更新処理
	public function update($thread_id, Request $request)
	{
		$params = $request->validate([
			'title' => 'required|max:50',
			'body' => 'required|max:2000',
			'category_id' => 'required|integer',
			'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:8192',
			'tweet_tags' => 'max:6000',
		]);

		// カテゴリチェック
		$category_data = Category::find($params['category_id']);
		if (empty($category_data->id)) {
			return back()->withInput();
		}

		// サムネイル画像変更
		if (!empty($params["image"])) {
			\UtilityService::save_thumbnail($thread_id, $params['image']);
			unset($params['image']);
		}
		$thread = Thread::findOrFail($thread_id);
		$thread->fill($params)->save();

		return redirect()->route('threads.show', ['thread' => $thread]);
	}

	/**
	 * 選択されたタグを含んでいるスレッドを返却する
	 * 
	 * @param object $request
	 * @param int $tag_id 選択されたタグid
	 */
	public function tag_search(Request $request, int $tag_id) 
	{
		// タグidからタグのインスタンス取得
		$tag_data = Tag::findOrFail($tag_id);
		// Tagモデルのインスタンスからタグに対応するスレッドを全取得
		$threads = $tag_data->threads()->orderby('thread_id', 'desc')->paginate(10);
		$user_agent = $request->header('User-Agent');

		list($threads, $device) = \UtilityService::format_thread($threads, $user_agent);

		$params = [
			'threads' => $threads,
			'device' => $device,
			'tag_data' => $tag_data,
		];
		return view('threads.index', $params);
	}

}
