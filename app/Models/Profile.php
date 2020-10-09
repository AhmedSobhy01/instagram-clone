<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public $timestamps = false;
    protected $fillable = ['bio', 'website'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBioAttribute($value)
    {
        return $value ?? "";
    }

    public function getWebsiteAttribute($value)
    {
        return $value ?? "";
    }
}