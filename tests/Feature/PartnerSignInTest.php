<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PartnerSignInTest extends TestCase
{

    /** @test */
    public function is_redirected_if_already_logged_in()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->be($user);

        $this->get(route('login'))
            ->assertRedirect(route('partner.dashboard'));
    }

    /** @test */
    public function a_client_can_login()
    {
        $user = User::factory()->create(['password' => Hash::make('password'), 'role_id' => 3]);

        Livewire::test('auth.login')
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('authenticate');

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function is_redirected_to_the_home_page_after_login()
    {
        $user = User::factory()->create(['password' => Hash::make('password'), 'role_id' => 3]);

        Livewire::test('auth.login')
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('authenticate')
            ->assertRedirect(route('partner.dashboard'));
    }

}
