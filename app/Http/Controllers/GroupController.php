<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GroupController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Group/CreateGroup");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $group = Group::create([
            "name" => $request->name
        ]);

        $user = User::find(Auth::id());

        $user->groups()->attach($group);

        foreach ($request->members as $member) {
            $user1 = User::find($member);
            $user1->groups()->attach($group);
        }

        return response()->json([
            "status" => true,
            "message" => "Group Created Successfully"
        ]);
    }

    public function firstInviteMembers()
    {
        return User::with("groups")
            ->where("id", "!=", Auth::id())
            ->get();
    }

    public function remainInviteMembers($groupId)
    {
        $group = Group::find($groupId);

        return User::whereDoesntHave("groups", function ($query) use ($group) {
            $query->where("groups.id", $group->id);
        })->get();
    }

    public function join(Request $request)
    {
        $group = Group::find($request->group_id);

        foreach ($request->members as $member) {
            $user = User::find($member);
            $user->groups()->attach($group);
        }

        return response()->json([
            "status" => true,
            "message" => "Joined Group Successfully"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return Inertia::render("Group/ShowGroup", ["group" => $group, "members" => $group->users]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
