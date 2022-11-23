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
<body class="maxWidthMaxHeight">
    <nav class="navFijo">
        <div id="multiLanguage">@include('partials.language-switcher')</div>
        <div class="navLogo">
            <a class="navbar-brand" href="{{ url('/') }}">
                GEOMIR
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="navDiv">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('register'))
                        <div class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </div>
                    @endif
                @else
                    <div class="navElement">
                        <a><img src="../public/imatges/chincheta.png" alt=""></img>PLACES</a>
                    </div>
                    <div class="navElement">
                        <a><img src="../public/imatges/chincheta.png" alt=""></img>FILES</a>
                    </div>
                    <div class="navElement">
                        <a><img src="../public/imatges/chincheta.png" alt=""></img>RESSENYES</a>
                    </div>
                    <div class="navElement">
                        <a><img src="../public/imatges/chincheta.png" alt=""></img>LA MEVA AGENDA</a>
                    </div>
                    
                    <div class="navElement">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </ul>
        </div>
    </nav>

    <main class="mainHome">
        @yield('content')
    </main>
</body>
</html>
