<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['profile_url'];

    public function getProfileUrlAttribute($value)
    {
        return route('profile', $this->username);
    }

    public function getProfileImageAttribute($value)
    {
        return asset('storage/profile_images') . "/" . $value;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function followers()
    {
        return $this->belongsToMany(self::class, "follows", 'followed_id', 'user_id');
    }

    public function following()
    {
        return $this->belongsToMany(self::class, "follows", 'user_id', 'followed_id');
    }

    public function isFollowing(User $user)
    {
        return !!$this->following()->where('followed_id', $user->id)->count();
    }

    public function isFollowedBy(User $user)
    {
        return !!$this->followers()->where('followed_id', $user->id)->count();
    }

    public function follow(User $user)
    {
        return !!!$this->isFollowing($user) ? $this->following()->save($user) : $this->following()->detach($user);
    }

    public function likedPost(Post $post)
    {
        return !!$this->likes()->where('post_id', $post->id)->count();
    }
}