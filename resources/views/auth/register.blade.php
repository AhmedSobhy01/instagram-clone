@extends('layouts.auth')
@section('title', __("main.register") . " - " . config('app.name', 'Instagram Clone'))

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="container">
            <div class="card text-center">
                <div class="card-body">
                <h2 class="card-title py-3">{{ __("main.register") }}</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="username" class="col-md-3 ml-3 col-form-label text-md-right">{{ __('main.username') }}</label>

                        <div class="col-md-8">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-3 ml-3 col-form-label text-md-right">{{ __('main.email') }}</label>

                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-3 ml-3 col-form-label text-md-right">{{ __('main.password') }}</label>

                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-3 ml-3 col-form-label text-md-right">{{ __('main.confirm_password') }}</label>

                        <div class="col-md-8">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('main.register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-muted">
            <a href="{{ route("login") }}">{{ __("main.already_registered") }}</a>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
