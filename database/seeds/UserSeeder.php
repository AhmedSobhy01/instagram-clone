<?php

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)->create()->each(function ($user) {
            $profile = factory(Profile::class)->make();
            $user->profile()->save($profile);
        });

        $user = factory(User::class)->create([
            "name" => "Ahmed Sobhy",
            "username" => "ahmedsobhy",
            "email" => "test@test.com",
            "profile_image" => "default.jpg",
        ]);

        $user->profile()->save(factory(Profile::class)->make());

        for ($i = 0; $i < 20; $i++) {
            $user->follow(User::find($i + 1));
            User::find($i + 1)->follow($user);
        }
    }
}