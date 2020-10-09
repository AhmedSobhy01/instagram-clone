<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function upload()
    {
    }

    public function like(Request $request)
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
            $post = Post::find($request->postID);

            if (!$post) {
                return response()->json([
                    "error_code" => 404,
                    "error_title" => __("main.messages_title.post_delete_error"),
                    "message" => __("main.post_deleted")
                ], 404);
            }

            $post->like();

            return response()->json([
                "error_code" => 201,
                "error_title" => "",
                "error_message" => ""
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "error_code" => 500,
                "error_title" => __("messages_title.error"),
                "error_message" => __("main.error")
            ], 500);
        }
    }
}