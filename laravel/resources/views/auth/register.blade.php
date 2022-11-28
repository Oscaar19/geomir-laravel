@extends('layouts.app')

@section('content')
<div class="loginContainer maxWidthMaxHeight">
    <div class="messageContainer centrar">
        <p id="welcomeMessage"><b>Discover your friend's favourites places!</b></p>
    </div>
    <div class="formContainer">
        <div class="centrar loginTitleLetter"><b>{{ __('Register') }}</b></div>

        <div class="card-body centrar">
            <form class="maxWidthMaxHeight" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="formInput">
                    <input id="name" type="text" class="inputBackground form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="formInput">
                    <input id="email" type="email" placeholder="Email Address" class="inputBackground form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="formInput">
                    <input id="password" type="password" placeholder="Password" class="inputBackground form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="formInput">
                    <input id="password-confirm" type="password" placeholder="Confirm Password" class="inputBackground form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="formInput">
                    <button type="submit" class="loginButton">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
