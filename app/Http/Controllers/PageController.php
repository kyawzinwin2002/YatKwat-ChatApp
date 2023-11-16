<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\ChatMessage;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Request as ClientRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function dashboardUI()
    {
        return Inertia::render("Dashboard");
    }

    public function chatUI()
    {
        $user = User::find(Auth::id());

        return Inertia::render("Chat/Container",compact("user"));
    }

    public function groupUI()
    {
        return Inertia::render("Group/Container");
    }

    public function friendUI()
    {
        $user = User::with("sentFriendRequests")->find(Auth::id());

        return Inertia::render("Friends/Index", compact("user"));
    }

    public function requestUI()
    {
        $requests = FriendRequest::with(["sender"])
            ->where("receiver_id", Auth::id())
            ->where("status", Status::Pending)
            ->get();

        return Inertia::render("Requests/Index", compact("requests"));
    }

    public function singleUserUI(Request $request)
    {
        $user = User::find(Auth::id());
        return  Inertia::render("Chat/Show",["id" => $request->id,"name" => $request->name,"user" => $user]);
    }
}
