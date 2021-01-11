<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardTest extends TestCase
{
    /** @test */
    public function client_can_access_dashboard()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('client.dashboard'))
            ->assertOk();
    }

    /** @test */
    public function client_can_log_out()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function client_can_access_search_engine()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('client.search_engine'))
            ->assertOk();
    }

    /** @test */
    public function client_can_access_rfq_overview()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('client.rfqs'))
            ->assertOk();
    }

    /** @test */
    public function client_can_access_active_orders()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('client.active_orders'))
            ->assertOk();
    }

    /** @test */
    public function client_can_access_finished_orders()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('client.finished_orders'))
            ->assertOk();
    }

    /** @test */
    public function client_can_access_chat_module()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('client.chat'))
            ->assertOk();
    }

    /** @test */
    public function partner_can_access_dashboard()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('partner.dashboard'))
            ->assertOk();
    }

    /** @test */
    public function partner_can_log_out()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function partner_can_access_rfq_overview()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('partner.rfqs'))
            ->assertOk();
    }

    /** @test */
    public function partner_can_access_active_orders()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('partner.active_orders'))
            ->assertOk();
    }

    /** @test */
    public function partner_can_access_finished_orders()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('partner.finished_orders'))
            ->assertOk();
    }

    /** @test */
    public function partner_can_access_chat_module()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('partner.chat'))
            ->assertOk();

    }

    /** @test */
    public function partner_can_access_settings()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('partner.settings'))
            ->assertOk();
    }

    /** @test */
    public function partner_cant_access_client_dashboard()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('client.dashboard'))
            ->assertStatus(401);
    }

    /** @test */
    public function partner_cant_access_client_rfq_overview()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('client.rfqs'))
            ->assertStatus(401);
    }

    /** @test */
    public function partner_cant_access_client_active_orders()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('client.active_orders'))
            ->assertStatus(401);
    }

    /** @test */
    public function partner_cant_access_client_finished_orders()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('client.finished_orders'))
            ->assertStatus(401);
    }

    /** @test */
    public function partner_cant_access_client_chat_module()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('client.chat'))
            ->assertStatus(401);
    }

    /** @test */
    public function partner_cant_access_client_search_engine_module()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->get(route('client.search_engine'))
            ->assertStatus(401);
    }

    /** @test */
    public function client_cant_access_partner_dashboard()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('partner.dashboard'))
            ->assertStatus(401);
    }

    /** @test */
    public function client_cant_access_partner_rfq_overview()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('partner.rfqs'))
            ->assertStatus(401);
    }

    /** @test */
    public function client_cant_access_partner_active_orders()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('partner.active_orders'))
            ->assertStatus(401);
    }

    /** @test */
    public function client_cant_access_partner_finished_orders()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('partner.finished_orders'))
            ->assertStatus(401);
    }

    /** @test */
    public function client_cant_access_partner_chat_module()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('partner.chat'))
            ->assertStatus(401);
    }

    /** @test */
    public function client_cant_access_partner_settings()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $this->get(route('partner.settings'))
            ->assertStatus(401);
    }
}
