<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (!auth()->user()) {
                session()->put("redirectTo", url()->previous());
                return response()->json([
                    "code" => 401,
                    "message" => "Please Login To Follow",
                    "redirectUrl" => route("login")
                ], 401);
            }

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

            return $request->wantsJson() ? $posts->toJson() : abort(404);
        } catch (\Exception $e) {
            return response()->json([
                "code" => 500,
                "message" => "There has been error. Please try again"
            ], 500);
        }
    }
}