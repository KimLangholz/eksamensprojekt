<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('client.chat_view', ['user' => $user]);
    }
}
