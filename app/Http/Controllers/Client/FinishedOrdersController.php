<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class FinishedOrdersController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('client.finished_orders_view', ['user' => $user]);
    }
}
