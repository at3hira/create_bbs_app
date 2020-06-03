@extends('layout')

@section('content')
<main class="mc-wrapper main">
	@for($i = 0; $i < count($news_list); $i++)
		<a href="{{ $news_link[$i] }}">
			<p>{{ $news_list[$i] }}</p>
		</a>
	@endfor
	<article class="container mt-4">
		@foreach ($threads as $thread)
			<section class="card mb-4">
				<a class="card-link" href="{{ route('threads.show', ['thread' => $thread]) }}">
					<div class="thr_thumbnail">
						<img src="{{ \Config::get('app.imagePATH') }}/{{ $thread->img_url }}">
					</div>
					<div class="card-body">
						<h2 class="thread_title">{{ str_limit($thread->title, 60) }}</h2>
						@if ($device)
							<p class="card-text">
								{!! nl2br(e(str_limit($thread->body, 60))) !!}
							</p>
						@endif
						<div class="card-meta">
							<i class="far fa-clock"></i> {{ $thread->created_at->format('Y/m/d') }}
						</div>	
					</div>
				</a>	
			</section>			
		@endforeach
		<div class="pagination">
			{{ $threads->links() }}	
		</div>
	</article>
</main>
<aside class="right">
	aside
</aside>

@endsection
