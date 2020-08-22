<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class CommentsController extends Controller
{
	/**
	 * コメント作成
	 * @param object $request
	 */
	public function store(Request $request) 
	{
		$params = $request->validate([
			'thread_id' => 'required| exists:threads,id',
			'body' => 'required|max:2000',
		]);

		$thread = Thread::findOrFail($params['thread_id']);

		$thread->comment()->create($params);

		return redirect()->route('threads.show', ['id' => $thread->id]);
	}	
}
