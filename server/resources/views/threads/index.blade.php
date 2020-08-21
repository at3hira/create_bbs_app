@php
	if (!empty($tag_data)) {
		$title = $tag_data->name;
		$article = "article";
	}
@endphp

@extends('layout')
@section('content')
<main class="mc-wrapper main">
	@auth
	@if(Auth::user()->name == config('const.Users.ADMIN_USER'))
		<div class="mb-4">
			<a href="{{ action('ThreadsController@create') }}" class="btn btn-primary">
				スレッドを作成する
			</a>
		</div>
	@endif
	@endauth

	@if(!empty($tag_data))
		<div class="bread-area">
			<ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope
					itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="/">
						<span itemprop="name">Top</span>
					</a>
					<meta itemprop="position" content="1" />
				</li>

				<li itemprop="itemListElement" itemscope
					itemtype="https://schema.org/ListItem">
					<span itemprop="name">{{ $tag_data->name }}</span>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
		<section class='tag-name'>
			<p># {{ $tag_data->name }}</p>
		</section>
	@endif
	
	<article class="container mt-4">
		@foreach ($threads as $thread)
			<section class="card mb-4">
				<a class="card-link" href="{{ action('ThreadsController@show', $thread->id) }}">
					<div class="thr_thumbnail">
						<img class="thumbnail" src="{{ \Config::get('app.imagePATH') }}/{{ $thread->img_url }}">
					</div>
					<div class="card-body">
						<h2 class="thread_title">{{ $thread->title }}</h2>
						@if ($device)
							<p class="card-text">
								{!! nl2br(e(str_limit($thread->body, 60))) !!}
							</p>
						@endif
						<div class="card-meta">
							<i class="far fa-clock"></i> <span class="meta-date">{{ $thread->created_at->format('Y/m/d') }}</span>
						</div>	
						<ul class="tag-list">
							@foreach ($thread->tags as $tag)
								<div data-url="/threads/tag_search/{{ $tag->id }}" class="clickTagSearchList">
									<li class="tag-keyword">#{{ $tag->name }}</li>
								</div>
							@endforeach
						</ul>
					</div>
				</a>	
			</section>			
		@endforeach
		<div class="pagination">
			{{ $threads->links() }}	
		</div>
	</article>
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
