<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class RFQController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('partner.rfq_view', ['user' => $user]);
    }
}
