@extends('layout')

@section('content')
	<div class="container mt-4">
		<p class="btn_hamburger">
			<a href="#">
				<span></span>
				<span></span>
				<span></span>
			</a>
		</p>
		<section id="category_accordion" class="section_demo section_demo1">
            <div class="target">
                <ul class="category_list">
                    <li><a href="#">ITEM 1-1</a></li>
                    <li><a href="#">ITEM 1-2</a></li>
                    <li><a href="#">ITEM 1-3</a></li>
                    <li><a href="#">ITEM 1-4</a></li>
                </ul>
            </div>
		</section>
 

		<div class="mb-4">
		    <a href="{{ route('threads.create') }}" class="btn btn-primary">
      		投稿を新規作成する
    		</a>
		</div>
        @foreach ($threads as $thread)
            <div class="card mb-4">
				@if ($thread->img_url)
					<figure class="thr_thumbnail">
						<a class="card-link" href="{{ route('threads.show', ['thread' => $thread]) }}">
							<img src="{{ $thread->img_url }}">
						</a>	
					</figure>
				@endif

				<div class="card-body">
					<a class="card-link" href="{{ route('threads.show', ['thread' => $thread]) }}">
	                    <p class="thread_title">{{ $thread->title }}</p>
					</a>
	
					@if ($device)
						<p class="card-text">
    	                    {!! nl2br(e(str_limit($thread->body, 20))) !!}
						</p>
					@endif
					<div class="card-meta">
	                    <span class="mr-2">
	                        投稿 {{ $thread->created_at->format('Y.m.d') }}
	                    </span>

                        <span class="badge badge-primary">
                            コメント {{ $thread->comment->count() }}件
       	                </span>
					</div>	
                </div>
            </div>
		@endforeach
		<div class="time_line">
			<a class="twitter-timeline" data-width="500" data-height="500" href="https://twitter.com/bakittonews?ref_src=twsrc%5Etfw">Tweets by bakittonews</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div>
    </div>
@endsection
