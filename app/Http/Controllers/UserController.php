<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function follow(Request $request)
    {
        $user = User::find(request()->userID);

        if (!$user) {
            return response()->json([
                "code" => 404,
                "message" => "Seems like the user has been deleted."
            ], 404);
        }

        if (!auth()->user()) {
            session()->put("redirectTo", url()->previous());
            return response()->json([
                "code" => 401,
                "message" => "Please Login To Follow",
                "redirectUrl" => route("login")
            ], 401);
        }

        $action = auth()->user()->follow($user);

        if ($action) {
            return response()->json([
                "code" => 201,
                "message" => ""
            ], 201);
        }

        return response()->json([
            "code" => 500,
            "message" => "There has been error. Please try again"
        ], 500);
    }

    public function likePost($id)
    {
        if (Post::find($id)->like()) {
            return 'done';
        } else {
            return 'fail';
        }
    }
}