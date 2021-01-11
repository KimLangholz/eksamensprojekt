<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class RFQController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('client.rfq_view', ['user' => $user]);
    }
}
