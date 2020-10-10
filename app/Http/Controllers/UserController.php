<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function follow(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        if (!auth()->check()) {
            return response_unauthenticated();
        }

        $validator = Validator::make($request->all(), [
            'userID' => 'required|integer',
        ], [
            'userID.required' => __('custom_validation.userID.required'),
            'userID.integer' => __('custom_validation.userID.integer'),
        ]);

        if ($validator->fails()) {
            return response_invalid_request(__("main.messages_title.invalid_inputs"), array_values($validator->getMessageBag()->toArray())[0][0]);
        }

        try {
            $user = User::find($request->userID);

            if (!$user) {
                return response_not_found(__("main.messages_title.user_delete_error"), __("main.user_delete_error"));
            }

            DB::beginTransaction();
            if (auth()->user()->follow($user)) {
                return response_created();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response_server_error();
        }
    }
}