<?php

namespace App\Http\Controllers;

use App\Models\User;

class FriendController extends Controller
{
    public function friendsAndStrangers($userId)
    {
        $user = User::with(['friendships', 'inverseFriendships'])->find($userId);

        $friendIds = $user->friendships->pluck("friend_id")->toArray();

        $inverseIds = $user->inverseFriendships->pluck("user_id")->toArray();

        $allFriendIds = array_merge($friendIds, $inverseIds);

        $allFriendIds = array_filter($allFriendIds, function ($id) use ($user) {
            return $id && $id != $user->id;
        });

        $friends = User::whereIn("id", $allFriendIds)->get();

        $strangers = User::whereNotIn("id", $allFriendIds)
            ->where("id", "<>", $user->id)
            ->get();

        return response()->json([
            "friends" => $friends,
            "strangers" => $strangers
        ]);
    }
}
