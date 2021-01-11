<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class FinishedOrdersController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('partner.finished_orders_view', ['user' => $user]);
    }
}
