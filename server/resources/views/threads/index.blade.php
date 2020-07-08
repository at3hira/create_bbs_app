@extends('layout')

@section('content')
<main class="mc-wrapper main">
	@auth
	@if(Auth::user()->name == config('const.Users.ADMIN_USER'))
		<div class="mb-4">
			<a href="{{ route('threads.create') }}" class="btn btn-primary">
				スレッドを作成する
			</a>
		</div>
	@endif
	@endauth
	{{--@for($i = 0; $i < count($news_list); $i++)
		<a href="{{ $news_link[$i] }}">
			<p>{{ $news_list[$i] }}</p>
		</a>
	@endfor
	--}}
	<article class="container mt-4">
		@foreach ($threads as $thread)
			@if($loop->index <= 2 && !$device && $threads->currentPage() === 1)
			<section class="card mb-4 latest-items">
					<a class="card-link" href="{{ route('threads.show', ['thread' => $thread]) }}">
						<div class="latest-thumbnail">
							<img src="{{ \Config::get('app.imagePATH') }}/{{ $thread->img_url }}">
						</div>
						<div class="latest-body">
							<h2 class="thread_title">{{ str_limit($thread->title, 60) }}</h2>
							<div class="card-meta">
								<i class="far fa-clock"></i> {{ $thread->created_at->format('Y/m/d') }}
							</div>	
						</div>
					</a>	
				</section>	
			@else

			<section class="card mb-4">
				<a class="card-link" href="{{ route('threads.show', ['thread' => $thread]) }}">
					<div class="thr_thumbnail">
						<img src="{{ \Config::get('app.imagePATH') }}/{{ $thread->img_url }}">
					</div>
					<div class="card-body">
						<h2 class="thread_title">{{ str_limit($thread->title, 60) }}</h2>
						<div class="card-meta">
							<i class="far fa-clock"></i> <span class="meta-date">{{ $thread->created_at->format('Y/m/d') }}</span>
						</div>	
						{{--@if ($device)
							<p class="card-text">
								{!! nl2br(e(str_limit($thread->body, 60))) !!}
							</p>
						@endif
						--}}
					</div>
				</a>	
			</section>			
			@endif
		@endforeach
		<div class="pagination">
			{{ $threads->links() }}	
		</div>
	</article>
</main>
<div class="right">
	aside
						</div>

@endsection
