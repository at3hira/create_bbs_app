<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Laravel BBS</title>

	{{--<link
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"
	>--}}
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/site.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700|Noto+Sans+JP:400,700" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div id="app">
    <header class="navbar navbar-dark bg-dark header">
        <div class="container">
            <a class="navbar-brand" href="{{ url('') }}">
                BBS PROTO
            </a>
        </div>
        @auth
            {{ Auth::user()->name }}
        @endauth
    </header>

    @yield('content')
    
    <footer class="footer">
        <div class="time_line">
            {{--<a class="twitter-timeline" data-width="500" data-height="500" href="https://twitter.com/bakittonews?ref_src=twsrc%5Etfw">Tweets by bakittonews</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>--}}
        </div>
    </footer>
    </div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
