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
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(Auth::id());
        return $user->groups;
    }

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

    public function join(Request $request)
    {
        $group = Group::find($request->group_id);

        foreach($request->members as $member)
        {
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
        return Inertia::render("Group/ShowGroup", compact("group"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
