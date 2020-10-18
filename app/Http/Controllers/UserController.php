<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AccountEdit;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit(AccountEdit $request)
    {
        try {
            DB::beginTransaction();

            if (!(Hash::check($request->current_password, auth()->user()->password))) {
                return redirect()->route('account.edit')->with("error", __("main.current_password_wrong"));
            }

            if (strcmp($request->current_password, $request->password) == 0) {
                return redirect()->route('account.edit')->with("error", __("main.new_password_same_as_current"));
            }

            auth()->user()->password = Hash::make($request->password);
            auth()->user()->save();

            DB::commit();
            return redirect()->route('account.edit')->with('success', __('main.password_updated'));
        } catch (\Exception $e) {
            return redirect()->route('account.edit')->with('error', __('main.error'));
        }
    }

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
                DB::commit();
                return response_created();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response_server_error();
        }
    }
}