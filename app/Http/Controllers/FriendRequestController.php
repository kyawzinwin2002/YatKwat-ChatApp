<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\FriendRequest;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function index()
    {
        return FriendRequest::all();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        FriendRequest::create([
            "sender_id" => Auth::id(),
            "receiver_id" => $request->receiver_id,
            "status" => Status::Pending
        ]);

        return response()->json([
            "status" => true,
            "message" => "Send request successfully"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $friendRequest = FriendRequest::with("sender")
            ->where("sender_id", $id)
            ->where("receiver_id", Auth::id())->first();


        $friendRequest->update([
            "status" => Status::Accepted
        ]);

        Friendship::create([
            "user_id" => Auth::id(),
            "friend_id" => $friendRequest->sender->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $request = FriendRequest::find($id);

        $request->delete();

        return response()->json([
            "status" => true,
            "message" => "Delete request Successfully"
        ]);
    }
}
