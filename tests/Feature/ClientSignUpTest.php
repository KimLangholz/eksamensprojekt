<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClientSignUpTest extends TestCase
{
    /** @test */
    public function a_guest_can_signup_as_a_client()
    {
        Livewire::test('client.auth.sign-up')
            ->set('name', 'Kim Langholz')
            ->set('email', 'contact@client.com')
            ->set('phone', '12131415')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'password')
            ->set('cvr','00000001')
            ->set('company_name','Partform')
            ->set('company_address','Stenderup 17')
            ->set('zipcode','6400')
            ->set('city','Sønderborg')
            ->set('country','Danmark')
            ->call('registerClientAndUser')
            ->assertRedirect(route('client.dashboard'));

        $this->assertTrue(User::whereEmail('contact@client.com')->exists());
        $this->assertEquals('contact@client.com', Auth::user()->email);
    }

    /** @test */
    public function client_is_redirected_if_already_logged_in()
    {
        $this->be(User::factory()->create(['role_id' => 2]));

        $this->get(route('client.signup'))
            ->assertRedirect(route('client.dashboard'));
    }

    /** @test */
    function name_is_required_pass_with_input()
    {
        Livewire::test('client.auth.sign-up')
            ->set('name', 'Kim')
            ->call('registerClientAndUser')
            ->assertHasNoErrors(['name' => 'required']);
    }

    /** @test */
    function email_is_required_fail_with_no_input()
    {
        Livewire::test('client.auth.sign-up')
            ->set('email', '')
            ->call('registerClientAndUser')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    function email_is_required_pass_with_correct_email()
    {
        Livewire::test('client.auth.sign-up')
            ->set('email', 'kontakt@kimlangholz.dk')
            ->call('registerClientAndUser')
            ->assertHasNoErrors(['email' => 'required']);
    }

    /** @test */
    function email_is_valid_email()
    {
        Livewire::test('client.auth.sign-up')
            ->set('email', 'contact')
            ->call('registerClientAndUser')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    function email_hasnt_been_taken_already()
    {
        User::factory()->create(['email' => 'contact@client.com']);

        Livewire::test('client.auth.sign-up')
            ->set('email', 'contact@client.com')
            ->call('registerClientAndUser')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    function see_email_hasnt_already_been_taken_validation_message_as_user_types()
    {
        User::factory()->create(['email' => 'contact@client.com']);

        Livewire::test('client.auth.sign-up')
            ->set('email', 'contact@user.com')
            ->assertHasNoErrors()
            ->set('email', 'contact@client.com')
            ->call('registerClientAndUser')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    function password_is_required()
    {
        Livewire::test('client.auth.sign-up')
            ->set('password', '')
            ->set('passwordConfirmation', 'password')
            ->call('registerClientAndUser')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    function password_is_minimum_of_eight_characters()
    {
        Livewire::test('client.auth.sign-up')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('registerClientAndUser')
            ->assertHasErrors(['password' => 'min']);
    }

    /** @test */
    function password_matches_password_confirmation()
    {
        Livewire::test('client.auth.sign-up')
            ->set('email', 'contact@client.com')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'not-password')
            ->call('registerClientAndUser')
            ->assertHasErrors(['password' => 'same']);
    }

    /** @test */
    function phone_is_a_minimum_of_eight_characters()
    {
        Livewire::test('client.auth.sign-up')
            ->set('phone', '1234567')
            ->call('registerClientAndUser')
            ->assertHasErrors(['phone' => 'min']);
    }

    /** @test */
    function phone_is_ok_with_a_minimum_of_eight_characters()
    {
        Livewire::test('client.auth.sign-up')
            ->set('phone', '12345678')
            ->call('registerClientAndUser')
            ->assertHasNoErrors(['phone' => 'min']);
    }

    /** @test */
    function phone_is_required()
    {
        Livewire::test('client.auth.sign-up')
            ->set('phone', '')
            ->call('registerClientAndUser')
            ->assertHasErrors(['phone' => 'required']);
    }

    /** @test */
    function cvr_is_required()
    {
        Livewire::test('client.auth.sign-up')
            ->set('cvr', '')
            ->call('registerClientAndUser')
            ->assertHasErrors(['cvr' => 'required']);
    }

    /** @test */
    function cvr_is_not_valid_with_less_than_eight_characters()
    {
        Livewire::test('client.auth.sign-up')
            ->set('cvr', '1234567')
            ->call('registerClientAndUser')
            ->assertHasErrors(['cvr' => 'min']);
    }

    /** @test */
    function cvr_is_ok_with_exactly_eight_characters()
    {
        Livewire::test('client.auth.sign-up')
            ->set('cvr', '12345678')
            ->call('registerClientAndUser')
            ->assertHasNoErrors(['cvr' => 'min', 'cvr' => 'max']);
    }

    /** @test */
    function cvr_is_more_than_eight_characters()
    {
        Livewire::test('client.auth.sign-up')
            ->set('cvr', '123456789')
            ->call('registerClientAndUser')
            ->assertHasErrors(['cvr' => 'max']);
    }

    /** @test */
    function cvr_is_a_lot_more_than_eight_characters()
    {
        Livewire::test('client.auth.sign-up')
            ->set('cvr', '123456781231239')
            ->call('registerClientAndUser')
            ->assertHasErrors(['cvr' => 'max']);
    }

    /** @test */
    function company_name_is_required()
    {
        Livewire::test('client.auth.sign-up')
            ->set('company_name', '')
            ->call('registerClientAndUser')
            ->assertHasErrors(['company_name' => 'required']);
    }

    /** @test */
    function company_name_is_filled_out()
    {
        Livewire::test('client.auth.sign-up')
            ->set('company_name', 'Test firma')
            ->call('registerClientAndUser')
            ->assertHasNoErrors(['company_name' => 'required']);
    }

    /** @test */
    function company_address_is_required()
    {
        Livewire::test('client.auth.sign-up')
            ->set('company_address', '')
            ->call('registerClientAndUser')
            ->assertHasErrors(['company_address' => 'required']);
    }

    /** @test */
    function company_address_is_filled_out()
    {
        Livewire::test('client.auth.sign-up')
            ->set('company_address', 'Test firma')
            ->call('registerClientAndUser')
            ->assertHasNoErrors(['company_address' => 'required']);
    }

    /** @test */
    function zipcode_is_required()
    {
        Livewire::test('client.auth.sign-up')
            ->set('zipcode', '')
            ->call('registerClientAndUser')
            ->assertHasErrors(['zipcode' => 'required']);
    }

    /** @test */
    function zipcode_is_not_valid_with_less_than_0555()
    {
        Livewire::test('client.auth.sign-up')
            ->set('zipcode', 554)
            ->call('registerClientAndUser')
            ->assertHasErrors(['zipcode' => 'between']);
    }

    /** @test */
    function zipcode_is_ok_with_lower_border_value()
    {
        Livewire::test('client.auth.sign-up')
            ->set('zipcode', 555)
            ->call('registerClientAndUser')
            ->assertHasNoErrors(['zipcode' => 'between']);
    }

    /** @test */
    function zipcode_is_ok_with_median_value()
    {
        Livewire::test('client.auth.sign-up')
            ->set('zipcode', 6400)
            ->call('registerClientAndUser')
            ->assertHasNoErrors(['zipcode' => 'between']);
    }

    /** @test */
    function zipcode_is_ok_with_upper_border_value()
    {
        Livewire::test('client.auth.sign-up')
            ->set('zipcode', 9999)
            ->call('registerClientAndUser')
            ->assertHasNoErrors(['zipcode' => 'between']);
    }

    /** @test */
    function zipcode_is_invalid_with_more_than_9999_as_value()
    {
        Livewire::test('client.auth.sign-up')
            ->set('zipcode', 10000)
            ->call('registerClientAndUser')
            ->assertHasErrors(['zipcode' => 'between']);
    }

    /** @test */
    function zipcode_is_invalid_with_string_input()
    {
        Livewire::test('client.auth.sign-up')
            ->set('zipcode', 'ol1000')
            ->call('registerClientAndUser')
            ->assertHasErrors(['zipcode' => 'integer']);
    }

    /** @test */
    function city_is_required_fail_with_no_input()
    {
        Livewire::test('client.auth.sign-up')
            ->set('city', '')
            ->call('registerClientAndUser')
            ->assertHasErrors(['city' => 'required']);
    }

    /** @test */
    function city_is_required_pass_with_input()
    {
        Livewire::test('client.auth.sign-up')
            ->set('city', 'Sønderborg')
            ->call('registerClientAndUser')
            ->assertHasNoErrors(['city' => 'required']);
    }

    /** @test */
    function country_is_required_fail_with_no_input()
    {
        Livewire::test('client.auth.sign-up')
            ->set('country', '')
            ->call('registerClientAndUser')
            ->assertHasErrors(['country' => 'required']);
    }

    /** @test */
    function country_is_required_pass_with_input()
    {
        Livewire::test('client.auth.sign-up')
            ->set('country', 'Danmark')
            ->call('registerClientAndUser')
            ->assertHasNoErrors(['country' => 'required']);

    }
}
