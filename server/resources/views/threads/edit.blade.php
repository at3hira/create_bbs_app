@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="border p-4">
            <h1 class="h5 mb-4">
                投稿の編集
            </h1>

            <form method="POST" action="{{ route('threads.update', ['thread' => $thread]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <fieldset class="mb-4">
                    <div class="form-group edit-item">
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

                    <div id="image-app" class="form-group edit-item">
                        <label for="image">画像</label>
                        <div class="thr_thumbnail">
	    					<img src="{{ \Config::get('app.imagePATH') }}/{{ $thread->img_url }}">
                        </div>
                        <image-data></image-data>
                    </div>

                    <div class="form-group edit-item">
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

                    <div class="form-group edit-item">
                        <label for="sub_title">
                            見出し
                        </label>
                        <p class="mb-5">
                            {!! nl2br($thread->sub_title) !!}
            			</p>
                        <input
                            id="sub_title"
                            name="sub_title"
                            class="form-control {{ $errors->has('sub_title') ? 'is-invalid' : '' }}"
                            value="{{ old('sub_title') }}"
                            type="text"
                        >
                        @if ($errors->has('sub_title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('sub_title') }}
                            </div>
                        @endif
                    </div>

					<div class="form-group edit-item">
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

                    
                    <div class="form-group edit-item">
                        <label for="tags">
                            タグ
                        </label>
                        <input
                            id="tags"
                            name="tags"
                            class="form-control {{ $errors->has('tags') ? 'is-invalid' : '' }}"
                            value="{{ old('tags') ?: $tags }}"
                            type="text"
                        >
                        @if ($errors->has('tags'))
                            <div class="invalid-feedback">
                                {{ $errors->first('tags') }}
                            </div>
                        @endif
                    </div>

					<div class="form-group edit-item">
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
                            @foreach ($categorys as $category)
    							<label class="category-radio"><input name="category_id" type="radio" value="{{ $category->id }}">{{ $category->category_name }}</label>
                            @endforeach
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
