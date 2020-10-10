@extends('layouts.app')
@section('title', config('app.name', 'Instagram Clone'))

@push('styles')
<link rel="stylesheet" href="{{ asset("css/feed.css") }}">
@endpush

@section('content')
<div class="row w-100 m-0">
    <div class="col-md-6 offset-md-3 px-0">
        <div class="container">
            <posts-feed post-url="{{ route('post.index', 1) }}" feed-url="{{ route('feed') }}" like-url="{{ route('like') }}" comment-url="{{ route('comment.create') }}" auth-id="{{ auth()->id() }}" end-message="{{ __('main.end_message') }}" comment-error-required="{{ __('custom_validation.comment.required') }}" comment-error-max="{{ __('custom_validation.comment.max:255') }}" error-word="{{ __("main.messages_title.error") }}"></posts-feed>
        </div>
    </div>
</div>
@endsection
