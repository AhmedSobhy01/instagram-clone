<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index($username)
    {
        $user = User::firstWhere('username', $username);
        if (!$user) :
            return abort(404, __('main.user_not_found'));
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
}