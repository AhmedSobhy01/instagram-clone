@extends('layouts.app')
@section('title', $post->user->name . " on " . config('app.name', 'Instagram Clone') . ": \"" . $post->caption . "\"")

@push('styles')
<link rel="stylesheet" href="{{ asset("css/post.css") }}">
<style>
    @keyframes ldio-j0phwa9fshm {
    0% { transform: translate(-50%,-50%) rotate(0deg); }
    100% { transform: translate(-50%,-50%) rotate(360deg); }
    }
    .ldio-j0phwa9fshm div {
    position: absolute;
    width: 60px;
    height: 60px;
    border: 10px solid #000000;
    border-top-color: transparent;
    border-radius: 50%;
    }
    .ldio-j0phwa9fshm div {
    animation: ldio-j0phwa9fshm 1s linear infinite;
    top: 50px;
    left: 50px
    }
    .loadingio-spinner-rolling-dbisj67kqze {
    width: 50px;
    height: 50px;
    display: inline-block;
    overflow: hidden;
    background: none;
    }
    .ldio-j0phwa9fshm {
    width: 100%;
    height: 100%;
    position: relative;
    transform: translateZ(0) scale(0.5);
    backface-visibility: hidden;
    transform-origin: 0 0;
    }
    .ldio-j0phwa9fshm div { box-sizing: content-box; }
</style>
@endpush

@section('content')
<div class="row m-0">
    <div class="col-md-10 offset-md-1">
        <div class="row post">
            <div class="left col-md-8 p-0">
                <div class="post-content d-flex h-100">
                    <span class="post-skeleton w-100"></span>
                    <img src="{{ $post->image }}" alt="Post Image" class="post-image w-100">
                </div>
            </div>
            <post-right :post-data="{{ $post }}" like-url="{{ route('like.create') }}" get-likes-url={{ route('like.index') }} comments-get-url="{{ route('comment.index') }}" comment-create-url="{{ route('comment.create') }}" comment-error-required="{{ __('custom_validation.comment.required') }}" comment-error-max="{{ __('custom_validation.comment.max:255') }}"  error-word="{{ __("main.messages_title.error") }}"></post-right>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-sm show" id="likesModal" tabindex="-1" role="dialog" aria-labelledby="likesModal"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="likesModal">Likes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body py-1" style="max-height: 300px;overflow-y: scroll;">

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.querySelector(".post-image").addEventListener("load", () => {
            document.querySelector(".post-skeleton").style.visibility = "hidden";
        });
    </script>
@endpush
