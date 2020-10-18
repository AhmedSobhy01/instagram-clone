<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProfileRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileImageRequest;

class ProfileController extends Controller
{
    public function index($username)
    {
        $user = User::where('username', $username)->with(['posts' => function ($q) {
            $q->latest();
        }])->first();

        if (!$user) :
            return abort(404, __('main.messages_title.user_delete_error'));
        endif;
        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(ProfileRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            auth()->user()->update([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
            ]);

            auth()->user()->profile()->update([
                'bio' => $data['bio'],
                'website' => $data['website']
            ]);

            DB::commit();

            session()->flash('success', __("main.profile_updated"));
            return redirect()->route('profile.edit');
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', __("main.error"));
            return redirect()->route('profile.edit');
        }
    }

    public function changeImage(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        if (!auth()->check()) {
            return response_unauthenticated();
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required|base64image|base64max:4096|base64mimes:jpeg,png',
        ], [
            'image.required' => __('custom_validation.image.required'),
            'image.base64image' => __('custom_validation.image.image'),
            'image.base64max' => __('custom_validation.image.max:4000'),
            'image.base64mimes' => __('custom_validation.image.image'),
        ]);

        if ($validator->fails()) {
            return response_invalid_request(__("main.messages_title.invalid_inputs"), array_values($validator->getMessageBag()->toArray())[0][0]);
        }

        try {
            DB::beginTransaction();
            $image_type = explode("image/", explode(";base64,", $request->image)[0])[1];
            $file = uniqid() . "." . $image_type;

            $old_image = auth()->user()->getRawOriginal('profile_image');

            $image = Image::make($request->image)->resize(500, 500)->save("storage/profile_images/" . $file, 100);

            if ($old_image !== 'default.jpg') {
                Storage::disk('public')->delete('profile_images/' . $old_image);
            }

            auth()->user()->profile_image = $file;
            auth()->user()->save();

            DB::commit();
            return response_ok(__("main.messages_title.profile_image_updated_successfully"), __("main.profile_image_updated_successfully"));
        } catch (\Intervention\Image\Exception\NotReadableException $e) {
            DB::rollBack();
            return response_invalid_request(__("main.messages_title.invalid_inputs"), __('custom_validation.image.image'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response_server_error();
        }
    }
}