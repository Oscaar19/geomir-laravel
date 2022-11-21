<!doctype html>
<html class="maxWidthMaxHeight" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="appBody">
    <div id="app">
        <nav class="navFijo">
            <div class="logoGeomir centrar">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon">GEOMIR</span>
                </button>                
            </div>
            <div id="idiomsButton">
                @include('partials.language-switcher')                    
            </div>
        </nav>

        <main class="mainHome">
            <div id="welcomeMessage">
                <p class="homeMessage">Discover your friend's location and their favourite places!</p>
            </div>
            <div id="formulario">
                <div class="maxWidthMaxHeight">
                    @yield('content')
                    <li class="noDotList">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                </div>
            </div>            
        </main>
    </div>
</body>
</html>
