<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('client.dashboard_view',['user' => $user]);
    }
}
