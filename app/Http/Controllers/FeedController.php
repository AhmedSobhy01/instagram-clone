<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                "error_code" => 401,
                "error_title" => __("main.messages_title.login"),
                "error_message" => __("main.please_login_follow"),
                "redirectUrl" => route("login")
            ], 401);
        }

        try {
            $following = auth()->user()->following()->select('users.id')->get()->map(function ($item) {
                return $item->id;
            });

            $posts = Post::whereIn('user_id', $following)->with([
                'user' => function ($q) {
                    $q->select('id', 'name', 'username', 'profile_image');
                },
                "likes" => function ($q) {
                    $q->select('post_id', 'user_id')->with(['user' => function ($q) {
                        $q->select('id');
                    },]);
                },
                'comments' => function ($q) {
                    $q->inRandomOrder()->select('post_id', 'user_id', 'body')->limit(2)->with(['user' => function ($q) {
                        $q->select('id', 'name', 'username', 'profile_image');
                    }]);
                }
            ])->latest()->paginate(5);

            $posts->map(function ($item) {
                $item->user->url = route('profile', $item->user->username);
                return $item;
            });

            $r = [
                "error_code" => 200,
                "error_title" => "",
                "error_message" => ""
            ];

            return $request->wantsJson() ? array_merge($r, $posts->toArray()) : abort(404);
        } catch (\Exception $e) {
            return response()->json([
                "error_code" => 500,
                "error_title" => __("main.messages_title.error"),
                "error_message" => __("main.error") . $e,
            ], 500);
        }
    }
}