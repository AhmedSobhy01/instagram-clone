<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $urls = json_encode([
            'post' => [
                'index' => route('post.index', 1),
                'delete' => route('post.delete'),
            ],
            'feed' => [
                'index' => route('feed'),
            ],
            'like' => [
                'store' => route('like.store'),
            ],
            'comment' => [
                'store' => route('comment.store'),
            ],
        ]);

        $messages = json_encode([
            "words" => [
                "delete" => __("main.delete"),
                "likes" => __("main.likes"),
                "view_all" => __("main.view_all"),
                "post" => __("main.post"),
                "comments" => __("main.comments"),
            ],
            'end_of_page' => [
                'title' => __('main.end_message'),
                'message' => '',
            ],
            'comment_errors' => [
                'required' => [
                    'title' => __('main.messages_title.error'),
                    'message' => __('custom_validation.comment.required'),
                ],
                'max' => [
                    'title' => __('main.messages_title.error'),
                    'message' => __('custom_validation.comment.max:255'),
                ],
            ],
        ]);

        return view('home', compact('urls', 'messages'));
    }
}