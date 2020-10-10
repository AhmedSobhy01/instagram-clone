@extends('layouts.app')
@section('title', $post->user->name . " on " . config('app.name', 'Instagram Clone') . ": \"" . $post->caption . "\"")

@push('styles')
<link rel="stylesheet" href="{{ asset("css/post.css") }}">
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
            <post-right :post-data="{{ $post }}" like-url="{{ route('like') }}" comments-get-url="{{ route('comment.index') }}" comment-create-url="{{ route('comment.create') }}" comment-error-required="{{ __('custom_validation.comment.required') }}" comment-error-max="{{ __('custom_validation.comment.max:255') }}"  error-word="{{ __("main.messages_title.error") }}"></post-right>
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
