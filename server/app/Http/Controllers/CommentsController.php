<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class CommentsController extends Controller
{
	public function store(Request $request) 
	{
		$params = $request->validate([
			'thread_id' => 'required| exists:threads,id',
			'body' => 'required|max:2000',
		]);
	//	$params['body'] = htmlspecialchars($params['body']);
		$thread = Thread::findOrFail($params['thread_id']);

		$thread->comment()->create($params);

		return redirect()->route('threads.show', ['thread' => $thread]);
	}	
}
