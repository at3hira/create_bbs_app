<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Category;

class ThreadsController extends Controller
{
	public function index()
	{
		$threads = Thread::orderBy('created_at', 'desc')->get();

		return view('threads.index', ['threads' => $threads]);
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
			'body' => 'required|max:200',
			'category_id' => 'required|integer',
		]);

		// カテゴリデータチェック
		$category_data = Category::find($params['category_id']);
		if (empty($category_data->id)) {
			$error[] = "不正なカテゴリです。";
			return back()->withInput()->withErrors($error);
		}

		//debug
		$params['img_url'] = '/test/test.jpg';

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

		$category_data = Category::find($params['category_id']);
		if (empty($category_data->id)) {
			$error[] = "不正なカテゴリです。";
			return back()->withInput()->withErrors($error);
		}

		$thread = Thread::findOrFail($thread_id);
		$thread->fill($params)->save();

		return redirect()->route('threads.show', ['thread' => $thread]);
	}

}
