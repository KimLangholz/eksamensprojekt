<?php

namespace App\Http\Livewire\Partner\Auth;

use Livewire\Component;
use App\Models\Partner;
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

    public function registerPartnerAndUser()
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

        Partner::create([
            'cvr' => $this->cvr,
            'company_name' => $this->company_name,
            'company_address' => $this->company_address,
            'zipcode_id' => Zipcode::where('zipcode', $this->zipcode)->pluck('id')[0],
            'country_id' => Country::where('country', $this->country)->pluck('id')[0],
        ]);

        $partner = Partner::where('cvr', $this->cvr)->first();

        $user = User::Create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role_id' => 3,
            'company_type' => 'App\Models\Partner',
            'company_id' => $partner['id'],
            'password' =>  Hash::make($this->password),
            'remember_token' =>  $this->remember_token
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended(route('partner.dashboard'));
    }

    public function fetchDataFromCVR()
    {
        if(strlen((string)$this->cvr) !== 8){
            return;
        }
        $data = \Cvrapi\Cvrapi::get($this->cvr, 'dk', 'Fetching data for sign-up form');
        $this->company_name = $data->name;
        $this->company_address = $data->address;
        $this->zipcode = $data->zipcode;
        $this->city = $data->city;
        $this->country = 'Danmark';
    }

    public function render()
    {
        return view('livewire.partner.auth.sign_up')->extends('layouts.auth');
    }
}
