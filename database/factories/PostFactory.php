<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $images = [
        "67513988_335818783994176_7663579261202873614_n.jpg",
        "120124465_1430451183827962_5325615626796962699_n.jpg",
        "116715832576749616330194869157085740620650.jpg",
        "11888962414318176336703967508980291488214058.jpg",
        "11898037232025665731551943827968125985386401.jpg",
        "1220187447232007682679715068849702769242681.jpg",
        "B0zHjX1ioCan1U7idFzv2HgcddGfaLc4ewSP2bXB.jpeg",
        "NJoVuogGxgJ6cNWkNG30xYxfpJo3X6DdCWMayE4S.jpeg",
        "vf2kzltSnCN1VrtJ3REtFlbqQ7EaVmDVt0RMaOD1.jpeg",
        "1224384691926805123104802977702983213889946.jpg",
    ];
    return [
        'image' => $faker->randomElement($images),
        'caption' => $faker->text,
        'user_id' => random_int(1, User::count()),
    ];
});