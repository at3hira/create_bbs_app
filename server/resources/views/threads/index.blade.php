@extends('layout')

@section('content')
	<div class="mc-wrapper">
		<div class="container mt-4">
{{--			@if (!$device)
				<div class="btn_bar">
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
								<li><a href="{{ url('') }}">ITEM 1-1</a></li>
								<li><a href="#">ITEM 1-2</a></li>
								<li><a href="#">ITEM 1-3</a></li>
								<li><a href="#">ITEM 1-4</a></li>
							</ul>
						</div>
					</section>
					<div class="search-btn">
						<form id="searchform" role="search" action="/" method="get">
							<input class="search-text" name="search-text" type="text" placeholder="" />
							<i class="fa fa-search"></i>
						</form>
					</div>
				</div>
			@endif
			--}}
			<div class="mb-4">
				<a href="{{ route('threads.create') }}" class="btn btn-primary">
				投稿を新規作成する
				</a>
			</div>

			@foreach ($threads as $thread)
{{--				@if ($loop->first)
					<article class="card mb-4 topthumbnail">
						<div class="top_list">
							<a class="card-link" href="{{ route('threads.show', ['thread' => $thread]) }}">
								<img class="top_image" src="{{ $thread->img_url }}">
								<p class="thread_title top_thr">{{ str_limit($thread->title, 60) }}</p>
								<div class="card-meta top_meta">
									<span class="mr-2 top_meta_f">
										<i class="far fa-clock"></i> {{ $thread->created_at->format('Y.m.d') }}
										<i class="far fa-comments"></i> {{ $thread->comment->count() }}件
									</span>
								</div>	
							</a>	
						</div>
					</article>
				@else
--}}

					<article class="card mb-4">
						@if ($thread->img_url)
							<div class="thr_thumbnail">
								<a class="card-link" href="{{ route('threads.show', ['thread' => $thread]) }}">
									<img src="{{ \Config::get('app.imagePATH') }}/{{ $thread->img_url }}">
								</a>	
							</div>
						@endif

						<div class="card-body">
							<a class="card-link" href="{{ route('threads.show', ['thread' => $thread]) }}">
								<p class="thread_title">{{ str_limit($thread->title, 60) }}</p>
							</a>
			
							@if ($device)
								<p class="card-text">
									{!! nl2br(e(str_limit($thread->body, 60))) !!}
								</p>
							@endif
							<div class="card-meta">
								<i class="far fa-clock"></i> {{ $thread->created_at->format('Y.m.d') }}
								<i class="far fa-comments"></i> {{ $thread->comment->count() }}件
							</div>	
						</div>
					</article>
				{{--@endif--}}
			@endforeach
			<div class="pagination">
				{{ $threads->links() }}	
			</div>
			<div class="time_line">
				<a class="twitter-timeline" data-width="500" data-height="500" href="https://twitter.com/bakittonews?ref_src=twsrc%5Etfw">Tweets by bakittonews</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
			</div>
		</div>
	</div>
@endsection
