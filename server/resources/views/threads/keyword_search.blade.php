@extends('layout')

@section('content')
{{{-- キーワード検索結果ページ --}}}
<main class="mc-wrapper main">
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
				<span itemprop="name">{{ $keyword }}</span>
				<meta itemprop="position" content="2" />
			</li>
		</ol>
	</div>
	<section class='search-result'>
		<h3 class="search-result-title">Search Result</h3>
		<p class="search-result-sub-title">"{{ $keyword }}"の検索結果</p>
	</section>
	
	<article class="container mt-4">
		@foreach ($threads as $thread)
			<section class="card mb-4">
				<a class="card-link" href="{{ route('threads.show', ['id' => $thread->id]) }}">
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
			{{ $threads->appends(request()->input())->links() }}	
		</div>
	</article>
</main>
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
