@php
$article = "article";
$title = $thread->title;
$description = mb_substr($thread->body, 0, 40, "UTF-8");
$image = $thread->img_url;
@endphp

@extends('layout')
@section('content')
	<main class="container mt-4 main">
		@auth
		@if(Auth::user()->name == config('const.Users.ADMIN_USER'))
			<div class="mb-4">
				<a href="{{ action('ThreadsController@edit', $thread) }}" class="btn btn-primary">
					スレッドを編集する
				</a>
			</div>
		@endif
		@endauth

		
        <div class="border p-4">
            <h1 class="h5 mb-4 show-title">
                {{ $thread->title }}
			</h1>
			<div class="card-meta show-data">
				<i class="far fa-clock"></i> {{ $thread->created_at->format('Y.m.d') }}
				<i class="far fa-comments"></i> {{ $thread->comment->count() }}件
			</div>

			<div class="thr_show_thumbnail">
				<img src="{{ \Config::get('app.imagePATH') }}/{{ $thread->img_url }}">
			</div>

			<p class="mb-5 show-body">
                {!! nl2br($thread->body) !!}
			</p>

			<div class="subtitle">
				{{ nl2br($thread->sub_title) }}
			</div>

			<p class="mb-5 embed-tweet">
				{!! nl2br($thread->tweet_tags) !!}
			</p>
			<div class="tag-list">
				@foreach ($thread->tags as $tag)
					<div data-url="/threads/tag_search/{{ $tag->id }}" class="clickTagSearchList tag-keyword">#{{ $tag->name }}</div>
				@endforeach
			</div>

            <div class="comment">
                <h2 class="h5 mb-4 comment_section">
                    コメント
                </h2>

                @forelse($thread->comment as $comment)
                    <div class="border-top p-4">
                        <time class="text-secondary">
                            {{ $comment->created_at->format('Y.m.d H:i') }}
                        </time>
                        <p class="mt-2">
                            {!! nl2br(e($comment->body)) !!}
                        </p>
                    </div>
                @empty
                    <p>コメントはまだありません。</p>
                @endforelse
            </div>
			<form class="mb-4" method="POST" action="{{ route('comments.store') }}">
			    @csrf

			    <input
			        name="thread_id"
    	    		type="hidden"
    	   		 	value="{{ $thread->id }}"
    			>

			    <div class="form-group">
    	    		<label for="body">
    	    		    本文
    	    		</label>
	
			        <textarea
        			    id="body"
        			    name="body"
        			    class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"
        	    		rows="4"
					>{{ old('body') }}</textarea>

					@if ($errors->has('body'))
        		    	<div class="invalid-feedback">
        	    		    {{ $errors->first('body') }}
        	    		</div>
        			@endif
    			</div>

			    <div class="mt-4">
        			<button type="submit" class="btn btn-primary">
        			    コメントする
        			</button>
   		 		</div>
			</form>
        </div>
	</main>

	{{-- サイドバー --}}
	<div class="right">
		<div class='sidetop'>
			@foreach ($tags as $tag)
				<div class="sidetag">
					<a href="/threads/tag_search/{{ $tag->id }}">{{ $tag->name }}</a>
				</div>
			@endforeach
		</div>
	</div>

@endsection
