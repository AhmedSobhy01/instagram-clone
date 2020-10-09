<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function users(Request $request)
    {
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
                ->limit(20)->orderBy('weight', 'desc')->get();

            $users->map(function ($item) {
                unset($item->weight);
                $item->profileUrl = route('profile', $item->username);
                return $item;
            });

            $r = [
                "results" => $users->toArray(),
                "error_code" => 200,
                "error_title" => "",
                "error_message" => ""
            ];

            return $r;
        } catch (\Exception $e) {
            return response()->json([
                "error_code" => 500,
                "error_title" => __("messages_title.error"),
                "error_message" => __("main.error")
            ], 500);
        }
    }
}