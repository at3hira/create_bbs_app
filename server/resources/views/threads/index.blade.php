@extends('layout')

@section('content')
    <div class="container mt-4">
		<div class="mb-4">
		    <a href="{{ route('threads.create') }}" class="btn btn-primary">
      		投稿を新規作成する
    		</a>
		</div>
        @foreach ($threads as $thread)
            <div class="card mb-4">
                <div class="card-header">
                    {{ $thread->title }}
                </div>
				<div class="card-body">
					@if ($thread->img_url)
						<figure>
							<img src="{{ $thread->img_url }}" width="100px" height="100px">
						</figure>
					@endif
                    <p class="card-text">
                        {!! nl2br(e(str_limit($thread->body, 200))) !!}
					</p>
					<a class="card-link" href="{{ route('threads.show', ['thread' => $thread]) }}">
						続きを読む
					</a>
                </div>
                <div class="card-footer">
                    <span class="mr-2">
                        投稿日時 {{ $thread->created_at->format('Y.m.d') }}
                    </span>

                    @if ($thread->comment->count())
                        <span class="badge badge-primary">
                            コメント {{ $thread->comment->count() }}件
                        </span>
                    @endif
                </div>
            </div>
		@endforeach
		<div class="time-line">
			<a class="twitter-timeline" data-width="500" data-height="500" href="https://twitter.com/bakittonews?ref_src=twsrc%5Etfw">Tweets by bakittonews</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div>
    </div>
@endsection
