<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['image', 'caption'];

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
            $this->likes()->updateOrCreate([
                'user_id' => auth()->id()
            ]);
        } else {
            $this->likes()->delete(auth()->id());
        }
    }
}