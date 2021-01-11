<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('partner.chat_view', ['user' => $user]);
    }
}
