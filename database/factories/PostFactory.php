<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $images = [
        "0eOhfampRRaj22k7DgYTlWPw1g60nGWNsHhhyaMu.jpeg",
        "0MOVdGmPolb0Irmsr9TSg1IgQAWquPT7SXfHAjux.png",
        "6Y3I58XdEHufFc0Q0vHGigaNwLfld9Ossu8wZ0AY.jpeg",
        "81MGGqbLfy75UpcF86vaWAXvQNYseFQOR5OAO2zF.jpeg",
        "1220187447232007682679715068849702769242681.jpg",
        "B0zHjX1ioCan1U7idFzv2HgcddGfaLc4ewSP2bXB.jpeg",
        "NJoVuogGxgJ6cNWkNG30xYxfpJo3X6DdCWMayE4S.jpeg",
        "vf2kzltSnCN1VrtJ3REtFlbqQ7EaVmDVt0RMaOD1.jpeg",
        "ZMsfK8pKBrdi7uEqBKzXnnSFFZMuodPhF9VUiE8R.jpeg",
    ];
    return [
        'image' => $faker->randomElement($images),
        'caption' => $faker->text,
        'user_id' => random_int(1, User::count()),
    ];
});