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
        try {
            $post = Post::find($request->postID);

            if (!$post) {
                return response()->json([
                    "code" => 404,
                    "message" => "Seems like the post has been deleted."
                ], 404);
            }

            $post->like();

            return response()->json([
                "code" => 201,
                "message" => ""
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "code" => 500,
                "message" => "There has been error. Please try again" . $e
            ], 500);
        }
    }
}