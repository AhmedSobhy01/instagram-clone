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
                <h2 class="card-title text-center my-3">{{ __("main.edit_profile") }}</h2>
                <div class="card-body py-md-4">
                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="username">{{ __('main.username') }}: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username" id="username" value="{{ auth()->user()->username }}">
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">{{ __('main.name') }}:</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->name ?? "" }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('main.email') }}: <span class="text-danger">*</span></label>
                            <input class="form-control" name="email" id="email" value="{{ auth()->user()->email }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bio">{{ __('main.bio') }}:</label>
                        <textarea class="form-control" name="bio" id="bio">{{ auth()->user()->profile->bio }}</textarea>
                            @error('bio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="website">{{ __('main.website') }}:</label>
                            <input class="form-control" name="website" id="website" value="{{ auth()->user()->profile->website }}">
                            @error('website')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">{{ __('main.save_changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(session()->has('success'))
    <script>
        let popupId = "{{ uniqid() }}";
        if(!sessionStorage.getItem('shown-' + popupId)) {
            toastr.success("{{ session()->get('success') }}", "Profile Updated", {
                "closeButton": true,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "10000",
                "extendedTimeOut": "10000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "slideDown",
                "hideMethod": "slideUp"
            });
        }
        sessionStorage.setItem('shown-' + popupId, '1');
    </script>
    @endif
    @if(session()->has('error'))
    <script>
        let popupId = "{{ uniqid() }}";
        if(!sessionStorage.getItem('shown-' + popupId)) {
            toastr.error("{{ session()->get('error') }}", "Error", {
                "closeButton": true,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "10000",
                "extendedTimeOut": "10000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "slideDown",
                "hideMethod": "slideUp"
            });
        }
        sessionStorage.setItem('shown-' + popupId, '1');
    </script>
    @endif
@endpush
