@extends('layouts.app')

@section('content')
<div class="loginContainer maxWidthMaxHeight">
    <div class="messageContainer centrar">
        <p id="welcomeMessage"><b>Discover your friend's favourites places!</b></p>
    </div>
    <div class="formContainer">
        <div class="centrar loginTitleLetter"><b>{{ __('Login') }}</b></div>

        <div class="card-body centrar">
            <form class="maxWidthMaxHeight" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="formInput">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="formInput">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="formInput">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>

                <div class="formInput">
                    <button type="submit" class="loginButton">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
