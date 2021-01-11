<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class ActiveOrdersController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('client.active_orders_view', ['user' => $user]);
    }
}
