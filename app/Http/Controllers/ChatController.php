<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\Events\NewChatMessage;
use App\Events\SendMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function rooms()
    {
        return ChatRoom::all();
    }

    public function messages( $roomId )
    {
        return ChatMessage::where("chat_room_id",$roomId)
            ->with(["room","user"])
            ->orderBy("created_at","DESC")
            ->get();
    }

    public function sendMessage(Request $request)
    {
        $newMessage = ChatMessage::create([
            "chat_room_id" => $request->roomId ,
            "user_id" => Auth::id(),
            "message" => $request->messages
        ]);

        Message::dispatch($newMessage);

        return response()->json([
            "message" => "Message Created Successfully"
        ]);
    }
}
