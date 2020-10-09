@extends('layouts.app')
@section('title', config('app.name', 'Instagram Clone'))

@push('styles')
<link rel="stylesheet" href="{{ asset("css/feed.css") }}">
@endpush

@section('content')
<div class="row w-100 m-0">
    <div class="col-md-6 offset-md-3">
        <div class="container">
            <posts-feed feed-url="{{ route('feed') }}" like-url="{{ route('like') }}" comment-url="{{ route('comment') }}" auth-id="{{ auth()->id() }}" end-message="{{ __('main.end_message') }}"></posts-feed>
        </div>
    </div>
</div>
@endsection
