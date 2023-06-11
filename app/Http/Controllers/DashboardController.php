<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $statusFriends = $request->user()->friends(['sender.statuses', 'receiver.statuses']);
//        dd($statusFriends);
        return view('dashboard', compact('statusFriends'));
    }
}
