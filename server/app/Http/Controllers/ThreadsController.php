<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Category;
use Weidner\Goutte\GoutteFacade as GoutteFacade;

class ThreadsController extends Controller
{
	public function index(Request $request)
	{
		$threads = Thread::threadList()->paginate(10);

		// User-Agentを用いてデバイス判定
		$user_agent = $request->header('User-Agent');
		$device = \UtilityService::judge_device($user_agent);

		foreach ($threads as $thread) {
			$thread->body = str_replace(array("\r\n", "\r", "\n"), ' ', $thread->body);
		}

		/*
		* Goutteを使ってYahooトップニュースをスクレイピング
		*/ 
		$news_link = array();
		$news_list = array();
		$goutte = GoutteFacade::request('GET', 'https://news.yahoo.co.jp/');
		$goutte->filter('.topicsListItem ')->each(function ($node) use (&$news_list, &$news_link) {
			$news_link = $node->filter('a')->attr('href');
			$news_list[] = $node->text();
		});

		$params = [
			'threads' => $threads,
			'device' => $device,
			'news_link' => $news_link,
			'news_list' => $news_list,
		];

		return view('threads.index', $params);
	}

	public function create()
	{
		return view('threads.create');
	}

	// スレッド作成
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
		$params['img_url'] = \UtilityService::save_thumbnail($new_thr_id, $params['image']);
		unset($params['image']);

		Thread::create($params);
		return redirect()->route('top');
	}

	public function show($thread_id)
	{
		$thread = Thread::findOrFail($thread_id);

		return view('threads.show', [
			'thread' => $thread,
		]);
	}

	public function edit($thread_id) 
	{
		$thread = Thread::findOrFail($thread_id);

		return view('threads.edit', [
			'thread' => $thread,
		]);
	}

	// スレッド更新処理
	public function update($thread_id, Request $request)
	{
		$params = $request->validate([
			'title' => 'required|max:50',
			'body' => 'required|max:2000',
			'category_id' => 'integer',
		]);

		// カテゴリチェック
		$category_data = Category::find($params['category_id']);
		if (empty($category_data->id)) {
			return back()->withInput();
		}

		$thread = Thread::findOrFail($thread_id);
		$thread->fill($params)->save();

		return redirect()->route('threads.show', ['thread' => $thread]);
	}

}
