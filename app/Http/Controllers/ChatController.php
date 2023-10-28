<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function rooms()
    {
        return response()->json(["rooms" => ChatRoom::all()]);
    }

    public function messages( $roomId )
    {
        $messages = ChatMessage::with(["chat_rooms","users"])->where("chat_room_id",$roomId)->get();

        return response()->json([
            "messages" => $messages
        ]);
    }

    public function sendMessage(Request $request)
    {
        ChatMessage::create([
            "chat_room_id" => $request->chat_room_id,
            "user_id" => Auth::id(),
            "message" => $request->message
        ]);

        return response()->json([
            "message" => "Message Created Successfully"
        ]);
    }
}
