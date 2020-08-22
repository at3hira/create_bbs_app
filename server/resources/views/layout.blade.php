<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @isset($article)
        <title>{{ $title }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endisset
    @isset($description)
        <meta property="og:description" content="{{ $description }}" />
        <meta name="description" content="{{ $description }}">
    @endisset
    <!-- OGP Tag -->
    @isset($article)
        <meta property="og:title" content="{{ $title }}" />
        <meta property="og:type" content="{{ $article }}" />
    @else
        <meta property="og:title" content="{{ config('app.name') }}" />
        <meta property="og:type" content="website" />
    @endisset
    @isset($description)
        <meta property="og:description" content="{{ $description }}" />
        <meta property="og:image" content="{{ config('app.url') }}{{ \Config::get('app.imagePATH') }}/{{$image}}" />
    @endisset
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta property="og:url" content="{{ request()->fullUrl() }}" />

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/site.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700|Noto+Sans+JP:400,700" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div class="main-container">
    <header class="navbar navbar-dark bg-dark header">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
                <h1 class="header-title">{{ config('app.name', 'Laravel') }}</h1>
            </a>
            @auth
                <a href="{{ route('home') }}">{{ Auth::user()->name }}</a>
            @endauth
        </div>
        <div id="search-app" class="search-menu">
            <search-menu></search-menu>
        </div>
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
