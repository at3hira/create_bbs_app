@extends('layout')

@section('content')
	<div class="container mt-4">
		<div class="mb-4 text-right">
		    <a class="btn btn-primary" href="{{ route('threads.edit', ['thread' => $thread]) }}">
				編集する
			</a>
		</div>
        <div class="border p-4">
            <h1 class="h5 mb-4">
                {{ $thread->title }}
            </h1>

            <p class="mb-5">
                {!! nl2br(e($thread->body)) !!}
            </p>
			<form class="mb-4" method="POST" action="{{ route('comments.store') }}">
			    @csrf

			    <input
			        name="post_id"
    	    		type="hidden"
    	   		 	value="{{ $thread->id }}"
    			>

			    <div class="form-group">
    	    		<label for="body">
    	    		    本文
    	    		</label>
	
			        <textarea
        			    id="body"
        			    name="body"
        			    class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"
        	    		rows="4"
						>{{ old('body') }}
					</textarea>
       				@if ($errors->has('body'))
        		    	<div class="invalid-feedback">
        	    		    {{ $errors->first('body') }}
        	    		</div>
        			@endif
    			</div>

			    <div class="mt-4">
        			<button type="submit" class="btn btn-primary">
        			    コメントする
        			</button>
   		 		</div>
			</form>
            <section>
                <h2 class="h5 mb-4">
                    コメント
                </h2>

                @forelse($thread->comments as $comment)
                    <div class="border-top p-4">
                        <time class="text-secondary">
                            {{ $comment->created_at->format('Y.m.d H:i') }}
                        </time>
                        <p class="mt-2">
                            {!! nl2br(e($comment->body)) !!}
                        </p>
                    </div>
                @empty
                    <p>コメントはまだありません。</p>
                @endforelse
            </section>
        </div>
    </div>
@endsection
