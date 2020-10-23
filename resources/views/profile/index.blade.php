@extends('layouts.app')
@section('title', "@" . $user->username . " - " . config('app.name', 'Instagram Clone'))

@push('styles')
<link rel="stylesheet" href="{{ asset("css/profile.css") }}">
{{-- Full Screen Loader --}}
<style>
    .full-loader {
    position: fixed;
    z-index: 999;
    height: 2em;
    width: 2em;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    }

    .full-loader:before {
        content: "";
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(rgba(20, 20, 20, 0.8), rgba(0, 0, 0, 0.8));

        background: -webkit-radial-gradient(
            rgba(20, 20, 20, 0.8),
            rgba(0, 0, 0, 0.8)
        );
    }

    .full-loader:not(:required) {
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
    }

    .full-loader:not(:required):after {
        content: "";
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 150ms infinite linear;
        -moz-animation: spinner 150ms infinite linear;
        -ms-animation: spinner 150ms infinite linear;
        -o-animation: spinner 150ms infinite linear;
        animation: spinner 150ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0,
            rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0,
            rgba(255, 255, 255, 0.75) 0 1.5em 0 0,
            rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0,
            rgba(255, 255, 255, 0.75) -1.5em 0 0 0,
            rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0,
            rgba(255, 255, 255, 0.75) 0 -1.5em 0 0,
            rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0,
            rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0,
            rgba(255, 255, 255, 0.75) 0 1.5em 0 0,
            rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0,
            rgba(255, 255, 255, 0.75) -1.5em 0 0 0,
            rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0,
            rgba(255, 255, 255, 0.75) 0 -1.5em 0 0,
            rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
    }

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-moz-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-o-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>
@endpush

@section('content')
<div class="full-loader d-none">Loading&#8230;</div>
<div class="row w-100 m-0" style="font-size: 10px">
    <div class="col-lg-8 offset-lg-2">
        <header>
            <div class="container">
                <div class="profile">
                    <div class="profile-image">
                        <form action="{{ route('profile.changeImage') }}" method="post" class="position-relative" id="profile-image-form">
                            <input type="file" name="image" id="profile-image-file" class="d-none">
                            <img src="{{ $user->profile_image }}" alt="Profile Picture">
                            <label for="profile-image-file" class="profile-image-file-label m-0 d-flex justify-content-center align-items-center"><i class="fas fa-camera fa-2x"></i></label>
                        </form>
                    </div>
                    <div class="profile-user-settings d-flex align-items-center">
                        <h1 class="profile-user-name m-0">{{ $user->username }}</h1>
                        @if (auth()->user() && auth()->user()->id == $user->id)
                        <a href="{{ route('profile.edit') }}" class="btn profile-edit-btn">{{ __("main.edit_profile") }}</a>
                        <a href="{{ route('account.edit') }}" class="btn" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="{{ __("main.account_settings") }}"><span><i class="fas fa-cog fa-lg"></i></span></a>
                        @else
                        <follow-button :urls="{{ $urls }}" :messages="{{ json_encode(["words" => ["follow" => __("main.follow"), "unfollow" => __("main.unfollow"), "loading" => __("main.loading")]]) }}" user-id="{{ $user->id }}" follows="{{auth()->check() && auth()->user()->isFollowing($user) ? true : false}}"></follow-button>
                        @endif
                    </div>
                    <div class="profile-stats my-3">
                        <ul class="pl-0 m-0">
                            <li><span class="profile-stat-count" id="posts-count">{{ number_format($user->posts->count()) }}</span> {{ strtolower(__("main.posts")) }}</li>
                            <li><span class="profile-stat-count" id="followers-count">{{ shorten_number($user->followers->count()) }}</span> {{ strtolower(__("main.followers")) }}</li>
                            <li><span class="profile-stat-count" id="following-count">{{ shorten_number($user->following->count()) }}</span> {{ strtolower(__("main.following")) }}</li>
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
                                <li class="gallery-item-likes"><span class="visually-hidden">{{ __("main.likes") }}:</span><i class="fas fa-heart" aria-hidden="true"></i> {{ shorten_number($post->likes->count()) }}</li>
                                <li class="gallery-item-comments"><span class="visually-hidden">{{ __("main.comments") }}:</span><i class="fas fa-comment" aria-hidden="true"></i> {{ shorten_number($post->comments->count()) }}</li>
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
                </div>
            </div>
        </main>
    </div>
</div>

{{-- Profile Image Modal --}}
<div class="modal" id="profileImageModal" tabindex="-1" aria-labelledby="profileImageModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center">Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8 p-0">
                            <img src="" alt="Image" class="image-preview w-100" id="image-preview">
                        </div>
                        <div class="col-md-4 d-flex flex-column justify-content-center align-items-center">
                            <span class="h3">Preview:</span>
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary d-flex align-items-center mr-3 ml-auto" id="upload">
                    <div class="loadingio-spinner-rolling-azt7iucozal mr-1 d-none">
                        <div class="ldio-7lxobt9epcp">
                            <div></div>
                        </div>
                    </div>
                    Upload
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<followers-modal :urls="{{ $urls }}" :messages="{{ json_encode(["words" => ["followers" => __("main.followers"), "nothing_found" => __("main.nothing_found")]]) }}" user-id={{ $user->id }}></followers-modal>
<followings-modal :urls="{{ $urls }}" :messages="{{ json_encode(["words" => ["following" => __("main.following"), "nothing_found" => __("main.nothing_found")]]) }}" user-id={{ $user->id }}></followings-modal>
@endsection

@push('scripts')
    <script>
        $('[data-toggle="popover"]').popover();
        document.getElementById("followers-count").parentElement.addEventListener("click", () => {$("#followersModal").modal("show");});
        document.getElementById("following-count").parentElement.addEventListener("click", () => {$("#followingsModal").modal("show");});
    </script>
    <script src="js/profile.js"></script>
@endpush
