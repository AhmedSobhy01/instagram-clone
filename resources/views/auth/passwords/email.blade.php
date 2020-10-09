@extends('layouts.auth')
@section('title', __("main.reset_password") . " - " . config('app.name', 'Instagram Clone'))

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="container">
            <div class="card text-center">
                <div class="card-body">
                <h2 class="card-title py-3">{{ __("main.reset_password") }}</h2>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-3 ml-3 col-form-label">{{ __('main.email') }}</label>

                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0 mt-4">
                        <div class="col-md-8 offset-md-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('main.send_reset_link') }}
                            </button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
