@extends('layout')
@section('content')
    <div class="container mt-4">
        <div class="border p-4">
            <h1 class="h5 mb-4">
                投稿の新規作成
            </h1>

			<form method="POST" action="{{ route('threads.store') }}" enctype="multipart/form-data" >
                @csrf

                <fieldset class="mb-4">
                    <div class="form-group">
                        <label for="title">
                            タイトル
                        </label>
                        <input
                            id="title"
                            name="title"
                            class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            value="{{ old('title') }}"
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

					<div class="form-group">
						<label for="tweet_tags">ツイート埋め込み</label>
						<textarea
							id="tweet_tags"
							name="tweet_tags"
							class="form-control {{ $errors->has('tweet_tags') ? 'is-invalid' : '' }}"
							rows=2
						>{{ old('tweet_tags') }}</textarea>
						@if ($errors->has('tweet_tags'))
							<div class="invalid-feedback">
								{{$errors->first('tweet_tags')}}
							</div>
						@endif
					</div>

					<div class="form-group">
						<label for="image">画像</label>
						<input type="file" name="image">
					</div>

					<div class="form-group">
						<label for="category">
							カテゴリ
						</label>
						<div>
							<label><input name="category_id" type="radio" value="1">テスト</label>
						</div>

					</div>

					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
						@foreach ($errors->all() as $error)
							<li>{{$error}}</li>
						@endforeach
						</ul>
					</div>
					@endif

					<div class="mt-5">
                        <a class="btn btn-secondary" href="{{ route('top') }}">
                            キャンセル
                        </a>

                        <button type="submit" class="btn btn-primary">
                            投稿する
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
