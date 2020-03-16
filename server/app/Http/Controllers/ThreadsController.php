<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Category;

class ThreadsController extends Controller
{
	public function index(Request $request)
	{
		$threads = Thread::orderBy('created_at', 'desc')->get();

		$user_agent = $request->header('User-Agent');
		if ((strpos($user_agent, 'iPhone') !== false)
			|| (strpos($user_agent, 'iPod') !== false)
			|| (strpos($user_agent, 'Android') !== false)) {
			$device = false;
		} else {
			$device = true;
		}
		foreach ($threads as $thread) {
			$thread->body = str_replace(array("\r\n", "\r", "\n"), ' ', $thread->body);
		}
		return view('threads.index', ['threads' => $threads, 'device' => $device]);
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
			'tweet_tags' => 'max:2000',
		]);

		// カテゴリデータチェック
		$category_data = Category::find($params['category_id']);
		if (empty($category_data->id)) {
			return back()->withInput();
		}

		//image
		$new_thr_id = Thread::max('id') + 1;
		$img_path = storage_path('app/public/thread_img/');
		$img_file = 'thread_'. $new_thr_id. '.jpg';

		 // Intervention読込
		\Image::make($params['image'])
			->resize(1024, null, function($constraint) { // 縦横比保持　横幅のみ1024px
				$constraint->aspectRatio();
			})->save($img_path. $img_file);
		
		unset($params['image']);
		$params['img_url'] = str_replace('/var/www/html/storage/app/public/', 'storage/', $img_path. $img_file);

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
