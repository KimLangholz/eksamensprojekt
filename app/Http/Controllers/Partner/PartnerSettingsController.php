<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerSettingsController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('partner.settings_view', ['user' => $user]);
    }
}
