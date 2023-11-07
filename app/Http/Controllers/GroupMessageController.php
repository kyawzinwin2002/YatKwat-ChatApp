<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Models\Group;
use App\Models\GroupMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupMessageController extends Controller
{
    public function messages($groupId)
    {
        return GroupMessage::where("group_id", $groupId)
            ->with(["group", "user"])
            ->orderBy("created_at", "DESC")
            ->get();
    }

    public function sendMessage(Request $request)
    {
        $message = GroupMessage::create([
            "user_id" => Auth::id(),
            "group_id" => $request->groupId,
            "message" => $request->message
        ]);

        SendMessage::dispatch($message);

        return response()->json([
            "status" => true,
            "message" => "Message Created Successfully"
        ]);
    }
}
