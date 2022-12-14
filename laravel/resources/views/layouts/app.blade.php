<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
<body class="maxWidthMaxHeight colorFondo">
    <nav class="navFijo">
        <div class="navLogo">
            <a id="aLogo" href="{{ url('/dashboard') }}">
                <img src="../../../imatges/logo.PNG" class="imagenNav">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div id="navToolbar">
            <div id="multiLanguage">@include('partials.language-switcher')</div>
            <div class="navDiv">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('register'))
                            <div class="registerButton centrar">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </div>
                        @endif
                    @else
                        <div class="navElement">
                            <div class="emojiNav">
                                <img src="../../../imatges/chincheta.png" class="imagenNav"></img>
                            </div>
                            <div class="nombreNav">
                                <a href="{{ url('/places') }}" class="linkNav">LLOCS</a>
                            </div>                        
                        </div>
                        <div class="navElement">
                            <div class="emojiNav">
                                <img src="../../../imatges/archivo.png" class="imagenNav"></img>
                            </div>
                            <div class="nombreNav">
                                <a href="{{ url('/files') }}" class="linkNav">FITXERS</a>
                            </div>                        
                        </div>
                        <div class="navElement">
                            <div class="emojiNav">
                                <img src="../../../imatges/favoritos.png" class="imagenNav"></img>
                            </div>
                            <div class="nombreNav">
                                <a href="{{ url('/files') }}" class="linkNav">LLOCS PREFERITS</a>
                            </div> 
                        </div>
                        <div class="navElement">
                            <div class="emojiNav">
                                <img src="../../../imatges/reseña.png" class="imagenNav"></img>
                            </div>
                            <div class="nombreNav">
                                <a href="{{ url('/places') }}" class="linkNav">RESSENYES</a>
                            </div> 
                        </div>
                        <div class="navElement">
                            <div class="emojiNav">
                                <img src="../../../imatges/contactos.png" class="imagenNav"></img>
                            </div>
                            <div class="nombreNav">
                                <a href="{{ url('/places') }}" class="linkNav">LA MEVA AGENDA</a>
                            </div>
                        </div>
                        <a href="/aboutme">QUI SOM?</a>
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
        </div>
    </nav>

    <main class="centrar">
        @yield('content')
    </main>
</body>
</html>
