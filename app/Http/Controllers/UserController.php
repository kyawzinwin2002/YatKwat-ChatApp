<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::with("groups")->get();
    }

    public function members($groupId)
    {
        $group = Group::find($groupId);
        return  $group->users;
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


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
