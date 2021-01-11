<?php

namespace App\Http\Livewire\Client\Auth;

use Livewire\Component;
use App\Models\Client;
use App\Models\User;
use App\Models\Zipcode;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;


class SignUp extends Component
{

    /** @var integer */
    public $cvr = null;

    /** @var string */
    public $company_name = '';

    /** @var string */
    public $company_address = '';

    /** @var integer */
    public $zipcode = null;

    /** @var string */
    public $city = '';

    /** @var string */
    public $country = '';

    /** @var string */
    public $name = '';

    /** @var string */
    public $email = '';

    /** @var date */
    public $email_verified_at = '';

    /** @var string */
    public $phone = '';

    /** @var integer */
    public $role_id = 0;

    /** @var string */
    public $company_type = '';

    /** @var integer */
    public $company_id = 0;

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    /** @var string */
    public $remember_token = '';

    /** @var date */
    public $created_at = '';

    /** @var date */
    public $updated_at = '';

    /**
     * Function for signing up guest users as clients.
     *
     * @return void
     */
    public function registerClientAndUser()
    {
        $this->validate([
            'cvr' => 'required|min:8|max:8',
            'company_name' => 'required',
            'company_address' => 'required',
            'zipcode' => 'required|integer|between:555,9999',
            'city' => 'required',
            'country' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:8',
            'password' => 'required|same:passwordConfirmation|min:8',
        ]);

        Client::create([
            'cvr' => $this->cvr,
            'company_name' => $this->company_name,
            'company_address' => $this->company_address,
            'zipcode_id' => Zipcode::where('zipcode', $this->zipcode)->pluck('id')[0],
            'country_id' => Country::where('country', $this->country)->pluck('id')[0],
        ]);

        $client = Client::where('cvr', $this->cvr)->first();

        $user = User::Create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role_id' => 2,
            'company_type' => 'App\Models\Client',
            'company_id' => $client['id'],
            'password' =>  Hash::make($this->password),
            'remember_token' =>  $this->remember_token
        ]);


        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended(route('client.dashboard'));
    }

    public function render()
    {
        return view('livewire.client.auth.sign_up')->extends('layouts.auth');
    }

}
