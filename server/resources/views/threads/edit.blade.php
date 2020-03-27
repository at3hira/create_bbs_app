@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="border p-4">
            <h1 class="h5 mb-4">
                投稿の編集
            </h1>

            <form method="POST" action="{{ route('threads.update', ['thread' => $thread]) }}">
                @csrf
                @method('PUT')

                <fieldset class="mb-4">
                    <div class="form-group">
                        <label for="title">
                            タイトル
                        </label>
                        <input
                            id="title"
                            name="title"
                            class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            value="{{ old('title') ?: $thread->title }}"
                            type="text"
                        >
                        @if ($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="body">
                            本文
                        </label>
                        <p class="mb-5">
                            {!! nl2br($thread->body) !!}
            			</p>
                        <textarea
                            id="body"
                            name="body"
                            class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"
                            rows="8"
                        >{{ old('body') ?: $thread->body }}</textarea>
                        @if ($errors->has('body'))
                            <div class="invalid-feedback">
                                {{ $errors->first('body') }}
                            </div>
                        @endif
                    </div>
					<div class="form-group">
						<label for="tweet_tags">ツイート埋め込み</label>
                        <p class="mb-5">
                            {!! nl2br($thread->tweet_tags) !!}
            			</p>
						<textarea
							id="tweet_tags"
							name="tweet_tags"
							class="form-control {{ $errors->has('tweet_tags') ? 'is-invalid' : '' }}"
							rows="10"
						>{{ old('$thread->tweet_tags') ?: $thread->tweet_tags }}</textarea>
						@if ($errors->has('tweet_tags'))
							<div class="invalid-feedback">
								{{$errors->first('tweet_tags')}}
							</div>
						@endif
					</div>
					<div class="form-group">
						<label for="category">
							カテゴリ
						</label>
						<span>
						@if ($errors->any())
							<ul id="error" class="error">
						@foreach ($errors->all() as $error)
							{{$error}}
						@endforeach
							</ul>
						@endif
						</span>
						<div>
							<label><input name="category_id" type="radio" value="1">テスト</label>
						</div>
					</div>

                    <div class="mt-5">
                        <a class="btn btn-secondary" href="{{ route('threads.show', ['thread' => $thread]) }}">
                            キャンセル
                        </a>

                        <button type="submit" class="btn btn-primary">
                            更新する
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
