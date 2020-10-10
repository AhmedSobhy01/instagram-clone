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
            return response_unauthenticated();
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
                return response_invalid_request(__("main.messages_title.invalid_inputs"), array_values($validator->getMessageBag()->toArray())[0][0]);
            }

            $post = Post::find($request->postID);

            if (!$post) {
                return response_not_found(__("main.messages_title.post_delete_error"), __("main.post_deleted"));
            }

            $post->like();

            DB::commit();

            return response_created();
        } catch (\Exception $e) {
            DB::rollBack();
            return response_server_error();
        }
    }

    public function comment(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        if (!auth()->check()) {
            return response_unauthenticated();
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
                return response_invalid_request(null, array_values($validator->getMessageBag()->toArray())[0][0]);
            }

            $post = Post::find($request->postID);

            if (!$post) {
                return response_not_found(__("main.messages_title.post_delete_error"), __("main.post_delete_error"));
            }

            $commentId = $post->comment($request->comment)->id;

            $comment = Comment::select('id', 'body', 'user_id')->where('id', $commentId)->with(['user' => function ($q) {
                $q->select('id', 'username');
            }])->first();

            return \response_created("", "", ["comment" => $comment]);
        } catch (\Exception $e) {
            return response_server_error();
        }
    }
}