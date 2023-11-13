<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\FriendRequest;
use App\Models\Friendship;
use App\Models\User;
use Inertia\Inertia;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ParagonIE\Sodium\Compat;

class PageController extends Controller
{
    public function dashboardUI()
    {
        return Inertia::render("Dashboard");
    }

    public function chatUI()
    {
        return Inertia::render("Chat/Container");
    }

    public function groupUI()
    {
        return Inertia::render("Group/Container");
    }

    public function friendUI()
    {
        $user = User::find(Auth::id());

        return Inertia::render("Friends/Friends", compact("user"));
    }

    public function requestUI()
    {
        $requests = FriendRequest::with(["sender", "receiver"])
            ->where("receiver_id", Auth::id())
            ->where("status", Status::Pending)
            ->get();

        return Inertia::render("Friends/Request", compact("requests"));
    }
}
