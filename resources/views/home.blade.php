@extends('layouts.app')
@section('title', config('app.name', 'Instagram Clone'))

@push('styles')
<link rel="stylesheet" href="{{ asset("css/feed.css") }}">
@endpush

@section('content')
<div class="row w-100 m-0">
    <div class="col-md-6 offset-md-3 px-0">
        <div class="container">
            <posts-feed post-url="{{ route('post.index', 1) }}" feed-url="{{ route('feed') }}" like-url="{{ route('like.create') }}" comment-url="{{ route('comment.create') }}" auth-id="{{ auth()->id() }}" end-message="{{ __('main.end_message') }}" comment-error-required="{{ __('custom_validation.comment.required') }}" comment-error-max="{{ __('custom_validation.comment.max:255') }}" error-word="{{ __("main.messages_title.error") }}"></posts-feed>
        </div>
    </div>
    <div class="add-post-btn d-flex justify-content-center align-items-center" id="add-post-btn"  data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Add Post">
        <i class="fas fa-plus fa-2x"></i>
    </div>
</div>
{{-- Add Post Modal --}}
<div class="modal" id="addPostModal" tabindex="-1" aria-labelledby="addPostModal" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center">Add Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data" id="addPostForm">

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif

                    <input type="file" name="image" id="image" class="d-none">
                    <div class="dropzone">
                        <div class="loader my-3 d-none" id="post-upload-loader"></div>
                        <div class="dropzone-preview position-relative d-none" id="image-preview">
                            <span class="reset-image-btn" id="reset-btn"><i class="fas fa-times-circle fa-2x"></i></span>
                            <img src="" alt="Image" class="w-100">
                        </div>
                        <label for="image" class="dropzone-t d-flex flex-column justify-content-center align-items-center h-100" id="dropzone">
                            <span class="mb-3"><i class="fas fa-download fa-2x"></i></span>
                            <div class="h4">Drop file here or click to browse</div>
                        </label>
                        <span class="invalid-feedback" id="image-err" role="alert">
                            <strong>Image is required</strong>
                        </span>
                    </div>
                    <div class="form-group my-3">
                        <label for="caption" class="h6">Caption:</label>
                        <textarea type="text" class="form-control caption-area" id="caption" name="caption">{{ old('caption') }}</textarea>
                        <span class="invalid-feedback" id="caption-err" role="alert">
                            <strong>Caption is required</strong>
                        </span>
                        <span class="invalid-feedback" id="caption-err-max" role="alert">
                            <strong>Caption can't be more than 100 characters.</strong>
                        </span>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary d-flex align-items-center mr-3 ml-auto" id="uploadBtn">
                            <div class="loadingio-spinner-rolling-azt7iucozal mr-1 d-none">
                                <div class="ldio-7lxobt9epcp">
                                    <div></div>
                                </div>
                            </div>
                            Upload
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('[data-toggle="popover"]').popover();
</script>
@if(session()->has('addPostErr'))
<script>
    $("#addPostModal").modal("show");
</script>
@endif
<script src="js/upload.js"></script>
@endpush
