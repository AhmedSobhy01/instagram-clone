@extends('layouts.app')
@section('title', "@" . $user->username . " - " . config('app.name', 'Instagram Clone'))

@push('styles')
<link rel="stylesheet" href="{{ asset("css/profile.css") }}">
@endpush

@section('content')
<div class="row w-100 m-0" style="font-size: 10px">
    <div class="col-lg-8 offset-lg-2">
        <header>
            <div class="container">
                <div class="profile">
                    <div class="profile-image">
                        <img src="{{ $user->profile_image }}" alt="Profile Picture">
                    </div>
                    <div class="profile-user-settings d-flex align-items-center">
                        <h1 class="profile-user-name m-0">{{ $user->username }}</h1>
                        @if (auth()->user() && auth()->user()->id == $user->id)
                        <a href="{{ route('profile.edit') }}" class="btn profile-edit-btn">{{ __("main.edit_profile") }}</a>
                        @else
                        <follow-button post-to="{{ route("follow") }}" login-link="{{ route("login") }}" user-id="{{ $user->id }}" follows="{{auth()->user() && auth()->user()->isFollowing($user) ? true : false}}"></follow-button>
                        @endif
                    </div>
                    <div class="profile-stats my-3">
                        <ul class="pl-0 m-0">
                            <li><span class="profile-stat-count" id="posts-count">{{ $user->posts->count() }}</span> {{ strtolower(__("main.posts")) }}</li>
                            <li><span class="profile-stat-count" id="followers-count">{{ $user->followers->count() }}</span> {{ strtolower(__("main.followers")) }}</li>
                            <li><span class="profile-stat-count" id="following-count">{{ $user->following->count() }}</span> {{ strtolower(__("main.following")) }}</li>
                        </ul>
                    </div>
                    <div class="profile-bio">
                        <p><span class="profile-real-name">{{ $user->name }}</span> <span class="mt-1 d-block">{{ $user->profile->bio }}</span></p>
                    </div>
                </div>
            </div>
        </header>
        <hr>
        <main>
            <div class="container">
                <div class="gallery">
                    @forelse ($user->posts as $post)
                    <a class="gallery-item" tabindex="0" href="{{ route('post.index', $post->id) }}">
                        <img src="{{ $post->image }}" class="gallery-image" alt="Post Image">
                        <div class="gallery-item-info">
                            <ul>
                                <li class="gallery-item-likes"><span class="visually-hidden">{{ __("main.likes") }}:</span><i class="fas fa-heart" aria-hidden="true"></i> {{ $post->likes->count() }}</li>
                                <li class="gallery-item-comments"><span class="visually-hidden">{{ __("main.comments") }}:</span><i class="fas fa-comment" aria-hidden="true"></i> {{ $post->comments->count() }}</li>
                            </ul>
                        </div>
                    </a>
                    @empty
                    <div class="d-flex flex-column justify-content-center align-items-center mt-3" style="grid-column: 1/-1;">
                        <div><i class="fas fa-camera fa-7x rounded-circle border p-4 mb-3"></i></div>
                        <div class="display-4 text-center">
                        No Posts Yet
                        </div>
                    </div>
                    @endforelse

                    {{-- <div class="gallery-item-type">
                        <span class="visually-hidden">Video</span><i class="fas fa-video" aria-hidden="true"></i>
                    </div>
                    <div class="gallery-item-type">
                        <span class="visually-hidden">Gallery</span><i class="fas fa-clone" aria-hidden="true"></i>
                    </div> --}}
                    {{-- <div class="loader"></div> --}}

                </div>
            </div>
        </main>
    </div>
</div>
@endsection
