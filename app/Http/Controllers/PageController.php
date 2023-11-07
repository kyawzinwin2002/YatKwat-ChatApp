<?php

namespace App\Http\Controllers;

use Inertia\Inertia;


use Illuminate\Http\Request;

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
}
