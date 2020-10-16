@foreach ($likes as $like)
<div class="like py-2">
    <a href="{{ $like->user->profile_url }}" class="text-decoration-none">
        <div class="d-flex align-items-center">
            <div class="mr-3"><img src="{{ $like->user->profile_image }}" alt="User Image" style="width: 35px; height: 35px;"></div>
            <div>{{ $like->user->username }}</div>
        </div>
    </a>
</div>
@endforeach
