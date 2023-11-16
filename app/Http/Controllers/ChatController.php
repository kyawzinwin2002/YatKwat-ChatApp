<?php

namespace App\Http\Controllers;

use App\Events\SendChatMessage;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $messages = ChatMessage::with(["sender","receiver"])->where(function ($query) use ($request){
            $query->where("sender_id",Auth::id())
                ->where("receiver_id",$request->id);
        })
        ->orWhere(function ($query) use ($request){
            $query->where("sender_id",$request->id)
                ->where("receiver_id",Auth::id());
        })
        ->orderBy("created_at","DESC")
        ->get();

        return $messages;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = ChatMessage::create([
            "sender_id" => Auth::id(),
            "receiver_id" => $request->receiver_id,
            "message" => $request->message
        ]);

        SendChatMessage::dispatch($message);

        return response()->json([
            "status" => true,
            "message" => "Message Created Successfully"
        ]);
    }


}
