<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['image', 'caption'];

    protected $appends = ['likesCount', 'commentsCount', 'likedByCurrentUser'];

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    public function getLikedByCurrentUserAttribute()
    {
        return auth()->user()->likedPost($this);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function like()
    {
        if (!auth()->user()->likedPost($this)) {
            return $this->likes()->updateOrCreate([
                'user_id' => auth()->id()
            ]);
        } else {
            return $this->likes()->delete(auth()->id());
        }
    }

    public function comment(string $body)
    {
        return $this->comments()->create([
            'user_id' => auth()->id(),
            'body' => $body
        ]);
    }
}