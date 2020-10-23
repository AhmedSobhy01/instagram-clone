<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $images = [
        "0MOVdGmPolb0Irmsr9TSg1IgQAWquPT7SXfHAjux.png",
        "1220187447232007682679715068849702769242681.jpg",
        "B0zHjX1ioCan1U7idFzv2HgcddGfaLc4ewSP2bXB.jpeg",
        "NJoVuogGxgJ6cNWkNG30xYxfpJo3X6DdCWMayE4S.jpeg",
        "vf2kzltSnCN1VrtJ3REtFlbqQ7EaVmDVt0RMaOD1.jpeg",
        "ZMsfK8pKBrdi7uEqBKzXnnSFFZMuodPhF9VUiE8R.jpeg",
        "11898037232025665731551943827968125985386401.jpg",
    ];
    return [
        'image' => $faker->randomElement($images),
        'caption' => $faker->text,
        'user_id' => random_int(1, User::count()),
    ];
});