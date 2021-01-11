<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('partner.dashboard_view',['user' => $user]);
    }
}
