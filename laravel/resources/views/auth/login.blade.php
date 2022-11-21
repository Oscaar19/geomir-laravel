@extends('layouts.app')

@section('content')
<div class="contenedorFormulario">
    <div class="formulario card">
        <div class="card-header centrar">
            <h3>{{ __('Login') }}</h3>
        </div>

        <div class="card-body maxWidthMaxHeight">
            <form class="maxWidthMaxHeight" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="maxWidth formInput">
                    <div>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="maxWidth formInput">
                    <div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="maxWidth formInput">
                    <div class="maxWidth">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="maxWidth centrar">
                        <button type="submit" class="loginButton">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
