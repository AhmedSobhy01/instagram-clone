<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AccountEdit;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit()
    {
        return view('account.edit');
    }

    public function update(AccountEdit $request)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();

            if (!(Hash::check($request->current_password, $user->password))) {
                return redirect()->route('account.edit')->with("error", __("main.current_password_wrong"));
            }

            if (strcmp($request->current_password, $request->password) == 0) {
                return redirect()->route('account.edit')->with("error", __("main.new_password_same_as_current"));
            }

            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();
            return redirect()->route('account.edit')->with('success', __('main.password_updated'));
        } catch (\Exception $e) {
            return redirect()->route('account.edit')->with('error', __('main.error'));
        }
    }

    public function follow(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        if (!auth()->check()) return response_unauthenticated();

        $validator = Validator::make($request->all(), [
            'userID' => 'required|integer',
        ], [
            'userID.required' => __('custom_validation.userID.required'),
            'userID.integer' => __('custom_validation.userID.integer'),
        ]);

        if ($validator->fails()) return response_invalid_request(__("main.messages_title.invalid_inputs"), array_values($validator->getMessageBag()->toArray())[0][0]);

        try {
            $user = User::find($request->userID);

            if (!$user) return response_not_found(__("main.messages_title.user_delete_error"), __("main.user_delete_error"));

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

    public function getFollowers(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

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

            $followers = $user->followers()->paginate(8, ['username', 'profile_image']);

            $last_page = $followers->currentPage() >= $followers->lastPage() ? true : false;

            $followers = $followers->map(function ($item) {
                unset($item['pivot']);
                return $item;
            });

            return response_ok("", "", ["followers" => $followers, "last_page" => $last_page]);
        } catch (\Exception $e) {
            return response_server_error($e);
        }
    }

    public function getFollowing(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

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

            $followings = $user->following()->paginate(8, ['username', 'profile_image']);

            $last_page = $followings->currentPage() >= $followings->lastPage() ? true : false;

            $followings = $followings->map(function ($item) {
                unset($item['pivot']);
                return $item;
            });

            return response_ok("", "", ["followings" => $followings, "last_page" => $last_page]);
        } catch (\Exception $e) {
            return response_server_error($e);
        }
    }
}