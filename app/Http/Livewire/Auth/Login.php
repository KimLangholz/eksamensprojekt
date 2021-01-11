<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

class Login extends Component
{
    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    public function authenticate()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            return;
        }
        $user = User::where('email', $this->email)->first();

        if ($user->role_id == 2) {

            return redirect()->route('client.dashboard');
        }

        if ($user->role_id == 3) {
            return redirect()->route('partner.dashboard');
        }

    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }
}
