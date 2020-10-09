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
        $user = User::find($request->userID);

        if (!$user) {
            return response()->json([
                "error_code" => 404,
                "error_title" => __("main.messages_title.user_delete_error"),
                "error_message" => __("main.user_delete_error")
            ], 404);
        }

        if (!auth()->check()) {
            return response()->json([
                "error_code" => 401,
                "error_title" => __("main.messages_title.login"),
                "error_message" => __("main.please_login_follow"),
                "redirectUrl" => route("login")
            ], 401);
        }

        try {
            DB::beginTransaction();
            if (auth()->user()->follow($user)) {
                return response()->json([
                    "error_code" => 201,
                    "error_title" => "",
                    "error_message" => ""
                ], 201);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "error_code" => 500,
                "error_title" => __("main.messages_title.error"),
                "error_message" => __('main.error')
            ], 500);
        }
    }
}