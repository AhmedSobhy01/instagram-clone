@extends('layouts.auth')
@section('title', __("main.login") . " - " . config('app.name', 'Instagram Clone'))

@section('content')
<div class="row m-0">
    <div class="col-md-6 offset-md-3">
        <div class="container">
            <div class="card text-center">
                <div class="card-body">
                <h2 class="card-title py-3">{{ __("main.login") }}</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group col-md-10 offset-md-1">
                        <div class="row">
                            <label for="email" class="col-form-label ml-3">{{ __('main.email') }}</label>
                        </div>

                        <div>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group col-md-10 offset-md-1">
                        <div class="row">
                            <label for="password" class="col-form-label ml-3">{{ __('main.password') }}</label>
                        </div>

                        <div>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 offset-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('main.remember_me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link mt-2" href="{{ route('password.request') }}">
                                    {{ __('main.forgot_password') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
                </div>
                <div class="card-footer text-muted">
                <a href="{{ route("register") }}">{{ __('main.not_registered') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
