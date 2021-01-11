<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class ActiveOrdersController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('partner.active_orders_view', ['user' => $user]);
    }
}
