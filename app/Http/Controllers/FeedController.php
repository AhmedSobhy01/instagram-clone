<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        if (!auth()->check()) {
            return \response_unauthenticated();
        }

        try {
            $following = auth()->user()->following()->select('users.id')->get()->map(function ($item) {
                return $item->id;
            });

            $posts = Post::whereIn('user_id', $following)->with([
                'user' => function ($q) {
                    $q->select('id', 'name', 'username', 'profile_image');
                },
            ])->latest()->paginate(5);

            $posts->map(function ($item) {
                $item->load(['comments' => function ($q) {
                    $q->inRandomOrder()->select('id', 'post_id', 'user_id', 'body')->with([
                        'user' => function ($q) {
                            $q->select('id', 'username');
                        },
                    ])->limit(2);
                }]);
                return $item;
            });

            return response_ok("", "", $posts->toArray());
        } catch (\Exception $e) {
            return response_server_error();
        }
    }
}