@extends('layouts.app')
@section('title', "Edit Profile - " . config('app.name', 'Instagram Clone'))

@push('styles')
    <style>
        .invalid-feedback {
            font-size: 90%;
            display: block;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <h2 class="card-title text-center my-3">{{ __("main.account_settings") }}</h2>
                <div class="card-body">

                    @if (session()->has('success'))
                    <div class="alert alert-success text-center">{{ session()->get('success') }}</div>
                    @endif

                    @if (session()->has('error'))
                    <div class="alert alert-danger text-center">{{ session()->get('error') }}</div>
                    @endif

                    <form action="{{ route('account.edit') }}" method="post">
                        @csrf
                        @method('patch')
                        <div class="h3 py-2 mb-4 border-bottom">Password</div>
                        <div class="form-group">
                            <label for="current_password">{{ __('main.current_password') }}:</label>
                            <input type="password" class="form-control" name="current_password" id="current_password">
                            @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">{{ __('main.new_password') }}:</label>
                            <input type="password" class="form-control" name="password" id="new_password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">{{ __('main.confirm_password') }}:</label>
                            <input type="password" class="form-control" name="password_confirmation" id="confirm_password">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">{{ __('main.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
