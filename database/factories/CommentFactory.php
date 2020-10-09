<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\User;
use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $user = User::inRandomOrder()->select('id')->limit(1)->get();
    return [
        'body' => $faker->text(100),
        'user_id' => $user->id
    ];
});