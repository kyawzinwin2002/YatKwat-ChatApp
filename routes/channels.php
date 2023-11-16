<?php

use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel("groupMessage.{groupId}",function($user,$groupId){
    return Auth::check();
});

Broadcast::channel("message.{receiver_id}",function($user,$receiver_id){
    return Auth::check();
});

