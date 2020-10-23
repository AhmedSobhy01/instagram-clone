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
            <post-right :post-data="{{ $post }}" :urls="{{ $urls }}" :messages="{{ $messages }}"></post-right>
        </div>
    </div>
</div>
<likes-modal :urls="{{ json_encode(["like" => ["index" => route("like.index")]]) }}" :messages="{{ json_encode(["words" => ["likes" => __("main.likes"), "nothing_found" => __("main.nothing_found")]]) }}" :post-id="{{ $post->id }}"></likes-modal>
@endsection

@push('scripts')
    <script>
        document.querySelector(".post-image").addEventListener("load", () => {
            document.querySelector(".post-skeleton").style.visibility = "hidden";
        });

        document.querySelector(".post-likes").addEventListener("click", () => {
            $("#likesModal").modal("show");
        });
    </script>
@endpush
