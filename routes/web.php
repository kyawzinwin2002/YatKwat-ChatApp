<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMessageController;
use App\Http\Controllers\PageController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth:sanctum')
    ->get('/authUser', function (Request $request) {
        $user = User::with(["groups", "messages"])->find(Auth::id());
        return $user;
    });

Route::middleware([
    "auth:sanctum",
    config('jetstream.auth_session'),
    "verified"
])->group(function () {

    Route::controller(PageController::class)->group(function () {
        Route::get("dashboard", "dashboardUI")->name("dashboard");
        Route::get("chat", "chatUI")->name("chat");
        Route::get("groups", "groupUI")->name("group");
        Route::get("friends", "friendUI")->name("friends");
        Route::get("requests", "requestUI")->name("requests");
        Route::get("chatMessage", "singleUserUI")->name("chatMessage");
    });

    Route::resource("group", GroupController::class);
    Route::controller(GroupController::class)->group(function () {
        Route::get("invite", "firstInviteMembers");
        Route::get("remain/{groupId}",  "remainInviteMembers");
        Route::post("group/join", "join");
    });

    Route::controller(GroupMessageController::class)->group(function () {
        Route::get("chat/group/{groupId}/messages", "messages");
        Route::post("chat/group/message", "sendMessage");
    });

    Route::controller(FriendController::class)->group(function () {
        Route::get("contacts/{userId}", "contacts");
    });

    Route::resource("request", FriendRequestController::class);
    
    Route::resource("userMessage", ChatController::class);
});
