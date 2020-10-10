<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public function users(Request $request)
    {
        if (!$request->wantsJson()) return abort(404);

        $validator = Validator::make($request->all(), [
            'q' => 'required',
        ], [
            'q.required' => __('custom_validation.q.required'),
        ]);

        if ($validator->fails()) {
            return response_invalid_request(__("main.messages_title.invalid_inputs"), array_values($validator->getMessageBag()->toArray())[0][0]);
        }

        try {
            $q = $request->q;
            $qStartsWith = $q . "%";
            $qStartsOrEndsWith = "%" . $q . "%";

            $relevanceQuery = 'IF(`username` LIKE ?, 20, IF(`username` LIKE ?, 6, 0)) + IF(`name` LIKE ?, 19, IF(`name` LIKE ?, 5, 0)) AS `weight`';
            $users = User::select(
                'name',
                'username',
                'profile_image'
            )
                ->selectRaw($relevanceQuery, [$qStartsWith, $qStartsOrEndsWith, $qStartsWith, $qStartsOrEndsWith])
                ->where('username', 'LIKE', $qStartsOrEndsWith)
                ->orWhere('name', 'LIKE', $qStartsOrEndsWith)
                ->limit(20)->orderBy('weight', 'desc')->get()->map(function ($v) {
                    unset($v->weight);
                    return $v;
                });

            return response_ok("", "", $users->toArray());
        } catch (\Exception $e) {
            return response_server_error();
        }
    }
}