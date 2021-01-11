<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Verify;
use App\Http\Livewire\Client\Auth\SignUp as ClientSignUp;
use App\Http\Livewire\Partner\Auth\SignUp as PartnerSignUp;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Partner\DashboardController as PartnerDashboardController;
use App\Http\Controllers\Client\ActiveOrdersController as ClientActiveOrdersController;
use App\Http\Controllers\Client\FinishedOrdersController as ClientFinishedOrdersController;
use App\Http\Controllers\Client\ChatController as ClientChatController;
use App\Http\Controllers\Client\RFQController as ClientRFQController;
use App\Http\Controllers\Client\SearchEngineController as ClientSearchEngineController;
use App\Http\Controllers\Partner\ActiveOrdersController as PartnerActiveOrdersController;
use App\Http\Controllers\Partner\FinishedOrdersController as PartnerFinishedOrdersController;
use App\Http\Controllers\Partner\ChatController as PartnerChatController;
use App\Http\Controllers\Partner\RFQController as PartnerRFQController;
use App\Http\Controllers\Partner\PartnerSettingsController as PartnerSettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');

    Route::get('client/signup', ClientSignUp::class)
        ->name('client.signup');

    Route::get('partner/signup', PartnerSignUp::class)
        ->name('partner.signup');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {

    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');

    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');
});


Route::middleware('auth', 'isClient')->group(function () {

    Route::get('client/dashboard', [ClientDashboardController::class, 'show'])
        ->name('client.dashboard');

    Route::get('client/active_orders', [ClientActiveOrdersController::class, 'show'])
        ->name('client.active_orders');

    Route::get('client/finished_orders', [ClientFinishedOrdersController::class, 'show'])
        ->name('client.finished_orders');

    Route::get('client/chat', [ClientChatController::class, 'show'])
        ->name('client.chat');

    Route::get('client/rfqs', [ClientRFQController::class, 'show'])
        ->name('client.rfqs');

    Route::get('client/search_engine', [ClientSearchEngineController::class, 'show'])
        ->name('client.search_engine');

    Route::get('client/search_engine/filter', [ClientSearchEngineController::class, 'filter'])
        ->name('client.search_engine/filter');
});

Route::middleware('auth', 'isPartner')->group(function () {

    Route::get('partner/dashboard', [PartnerDashboardController::class, 'show'])
        ->name('partner.dashboard');

    Route::get('partner/active_orders', [PartnerActiveOrdersController::class, 'show'])
        ->name('partner.active_orders');

    Route::get('partner/finished_orders', [PartnerFinishedOrdersController::class, 'show'])
        ->name('partner.finished_orders');

    Route::get('partner/chat', [PartnerChatController::class, 'show'])
        ->name('partner.chat');

    Route::get('partner/rfqs', [PartnerRFQController::class, 'show'])
        ->name('partner.rfqs');

    Route::get('partner/settings', [PartnerSettingsController::class, 'show'])
        ->name('partner.settings');
});
