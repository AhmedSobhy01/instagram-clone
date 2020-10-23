<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(Request $request, Post $post)
    {
        $post->load([
            'user' => function ($q) {
                $q->select('id', 'name', 'username', 'profile_image');
            },
        ]);

        $urls = json_encode([
            'home' => [
                'index' => route('home'),
            ],
            'post' => [
                'delete' => route('post.delete'),
            ],
            'like' => [
                'index' => route('like.index'),
                'store' => route('like.store'),
            ],
            'comment' => [
                'index' => route('comment.index'),
                'store' => route('comment.store'),
            ],
        ]);

        $messages = json_encode([
            "words" => [
                "likes" => __("main.likes"),
                "delete" => __("main.delete"),
                "post" => __("main.post"),
            ],
            "no_comments" => __("main.no_comments"),
            "comment_errors" => [
                "required" => [
                    "title" => __("main.messages_title.error"),
                    "message" => __("custom_validation.comment.required"),
                ],
                "max" => [
                    "title" => __("main.messages_title.error"),
                    "message" => __("custom_validation.comment.max:255"),
                ],
            ],
        ]);

        return view('post', compact('post', 'urls', 'messages'));
    }

    public function like(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        if (!auth()->check()) {
            return response_unauthenticated();
        }

        $validator = Validator::make($request->all(), [
            'postID' => 'required|integer|max:2147483647',
        ], [
            'postID.required' => __('custom_validation.post_id.required'),
            'postID.integer' => __('custom_validation.post_id.integer'),
        ]);

        if ($validator->fails()) {
            return response_invalid_request(__("main.messages_title.invalid_inputs"), array_values($validator->getMessageBag()->toArray())[0][0]);
        }

        try {
            DB::beginTransaction();

            $post = Post::find($request->postID);

            if (!$post) return response_not_found(__("main.messages_title.post_delete_error"), __("main.post_deleted"));

            $post->like();

            DB::commit();

            return response_created();
        } catch (\Exception $e) {
            DB::rollBack();
            return response_server_error($e);
        }
    }

    public function comment(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        if (!auth()->check()) return response_unauthenticated();

        try {

            $validator = Validator::make($request->all(), [
                'postId' => 'required|integer|max:2147483647',
                'comment' => 'required|string|max:255',
            ], [
                'postId.required' => __('custom_validation.post_id.required'),
                'postId.integer' => __('custom_validation.post_id.integer'),
                'comment.required' => __('custom_validation.comment.required'),
                'comment.string' => __('custom_validation.comment.string'),
                'comment.max' => __('custom_validation.comment.max:255'),
            ]);

            if ($validator->fails()) {
                return response_invalid_request(null, array_values($validator->getMessageBag()->toArray())[0][0]);
            }

            $post = Post::find($request->postId);

            if (!$post) return response_not_found(__("main.messages_title.post_delete_error"), __("main.post_delete_error"));

            $commentId = $post->comment($request->comment)->id;

            $comment = Comment::select('id', 'body', 'user_id', 'created_at')->where('id', $commentId)->with(['user' => function ($q) {
                $q->select('id', 'username', 'profile_image');
            }])->first();

            return \response_created("", "", ["comment" => $comment]);
        } catch (\Exception $e) {
            return response_server_error();
        }
    }

    public function getComments(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        $validator = Validator::make($request->all(), [
            'postId' => 'required|integer|max:2147483647',
        ], [
            'postID.required' => __('custom_validation.post_id.required'),
            'postID.integer' => __('custom_validation.post_id.integer'),
        ]);

        if ($validator->fails()) {
            return response_invalid_request(null, array_values($validator->getMessageBag()->toArray())[0][0]);
        }

        $comments = Post::find($request->postId)->comments()->select('id', 'post_id', 'user_id', 'body', 'created_at')->with(['user' => function ($r) {
            $r->select('id', 'username', 'profile_image');
        }])->latest()->paginate(config('constants.pagination.pagination_count'))->toArray();

        return response_ok("", "", $comments);
    }

    public function getLikes(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        $validator = Validator::make($request->all(), [
            'postId' => 'required|integer|max:2147483647',
        ], [
            'postId.required' => __('custom_validation.post_id.required'),
            'postId.integer' => __('custom_validation.post_id.integer'),
        ]);

        if ($validator->fails()) {
            return response_invalid_request(null, array_values($validator->getMessageBag()->toArray())[0][0]);
        }

        $post = Post::find($request->postId);
        if (!$post) return response_not_found(__("main.messages_title.post_delete_error"), __("main.post_delete_error"));

        $likes = $post->likes()->select('id', 'post_id', 'user_id')->with(["user" => function ($q) {
            $q->select('id', 'username', 'profile_image');
        }])->paginate(config('constants.pagination.pagination_count'));

        return response_ok("", "", $likes->toArray());
    }

    public function upload(PostRequest $request)
    {
        $image = $request->image->store('public/posts');
        auth()->user()->posts()->create([
            'image' => substr($image, 13),
            'caption' => $request->caption
        ]);
        return redirect()->route('home')->with('success', __('main.post_created_successfully'));
    }

    public function delete(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        if (!auth()->check()) return response_unauthenticated();

        $validator = Validator::make($request->all(), [
            'postId' => 'required|integer|max:2147483647',
        ], [
            'postId.required' => __('custom_validation.post_id.required'),
            'postId.integer' => __('custom_validation.post_id.integer'),
        ]);

        if ($validator->fails()) {
            return response_invalid_request(null, array_values($validator->getMessageBag()->toArray())[0][0]);
        }

        try {
            DB::beginTransaction();

            $post = auth()->user()->posts()->find($request->postId);
            if (!$post) return response_not_found(__("main.messages_title.post_delete_error"), __("main.post_delete_error"));

            Storage::disk('public')->delete('posts/' . $post->getRawOriginal('image'));
            $post->delete();

            DB::commit();

            return response_ok(__("main.messages_title.post_deleted_successfully"), __("main.post_deleted_successfully"));
        } catch (\Exception $e) {
            DB::rollBack();
            return response_server_error();
        }
    }
}