<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function upload()
    {
    }

    public function like(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        if (!auth()->check()) {
            return response()->json([
                "response_code" => 401,
                "error_title" => __("main.messages_title.login"),
                "error_message" => __("main.please_login"),
                "redirectUrl" => route("login")
            ], 401);
        }

        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'postID' => 'required|integer|max:2147483647',
            ], [
                'postID.required' => __('custom_validation.post_id.required'),
                'postID.integer' => __('custom_validation.post_id.integer'),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "response_code" => 400,
                    "error_title" => __("main.messages_title.invalid_inputs"),
                    "error_message" => array_values($validator->getMessageBag()->toArray())[0][0]
                ], 400);
            }

            $post = Post::find($request->postID);

            if (!$post) {
                return response()->json([
                    "response_code" => 404,
                    "error_title" => __("main.messages_title.post_delete_error"),
                    "error_message" => __("main.post_deleted")
                ], 404);
            }

            $post->like();

            DB::commit();

            return response()->json([
                "response_code" => 201,
                "error_title" => "",
                "error_message" => ""
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "response_code" => 500,
                "error_title" => __("main.messages_title.error"),
                "error_message" => __("main.error")
            ], 500);
        }
    }

    public function comment(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        if (!auth()->check()) {
            return response()->json([
                "response_code" => 401,
                "error_title" => __("main.messages_title.login"),
                "error_message" => __("main.please_login"),
                "redirectUrl" => route("login")
            ], 401);
        }

        try {

            $validator = Validator::make($request->all(), [
                'postID' => 'required|integer|max:2147483647',
                'comment' => 'required|string|max:255',
            ], [
                'postID.required' => __('custom_validation.post_id.required'),
                'postID.integer' => __('custom_validation.post_id.integer'),
                'comment.required' => __('custom_validation.comment.required'),
                'comment.string' => __('custom_validation.comment.string'),
                'comment.max' => __('custom_validation.comment.max:255'),
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "response_code" => 400,
                    "error_title" => __("main.messages_title.error"),
                    "error_message" => array_values($validator->getMessageBag()->toArray())[0][0]
                ], 400);
            }

            $post = Post::find($request->postID);

            if (!$post) {
                return response()->json([
                    "response_code" => 404,
                    "error_title" => __("main.messages_title.post_delete_error"),
                    "error_message" => __("main.post_delete_error")
                ], 404);
            }

            $commentId = $post->comment($request->comment)->id;

            $comment = Comment::select('id', 'body', 'user_id')->where('id', $commentId)->with(['user' => function ($q) {
                $q->select('id', 'username');
            }])->first();

            return response()->json([
                "response_code" => 201,
                "error_title" => "",
                "error_message" => "",
                "comment" => $comment
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "response_code" => 500,
                "error_title" => __("main.messages_title.error"),
                "error_message" => __("main.error"),
            ], 500);
        }
    }
}