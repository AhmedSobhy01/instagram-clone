<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function ($user) {
            $post = factory(Post::class)->make();
            $user->posts()->save($post);

            // User::find(3)->likes()->save($post);
            // User::find(4)->likes()->save($post);
            // User::find(5)->likes()->save($post);
            // User::find(6)->likes()->save($post);
            // User::find(7)->likes()->save($post);

            // $post->comments()->save(factory(Comment::class)->create());
        });
    }
}