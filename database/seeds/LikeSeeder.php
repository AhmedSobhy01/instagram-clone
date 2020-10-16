<?php

use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::inRandomOrder()->select('id')->limit(15)->get();
        $user->each(function ($user) {
            Like::create([
                "user_id" => $user->id,
                "post_id" => 1
            ]);
        });
    }
}