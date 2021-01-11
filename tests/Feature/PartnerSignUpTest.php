<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Partner\Auth\SignUp;

class PartnerSignUpTest extends TestCase
{

    /** @test */
    public function a_guest_can_signup_as_a_partner()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('name', 'Kim Langholz')
            ->set('email', 'contact@partner.com')
            ->set('phone', '23242526')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'password')
            ->set('cvr','00000002')
            ->set('company_name','Partform')
            ->set('company_address','Nalmadebro 26')
            ->set('zipcode','6300')
            ->set('city','Graasten')
            ->set('country','Danmark')
            ->call('registerPartnerAndUser')
            ->assertRedirect(route('partner.dashboard')); //TODO redirect to Manufacutrer dashboard

        $this->assertTrue(User::whereEmail('contact@partner.com')->exists());
        $this->assertEquals('contact@partner.com', Auth::user()->email);
    }

    /** @test  */
    function partner_can_utilize_cvr_lookup()
    {
        $this->actingAs(User::factory()->create(['role_id' => 3]));

        Livewire::test(SignUp::class)
            ->set('cvr', 20165715)
            ->call('fetchDataFromCVR')
            ->assertSet('company_name', 'DANFOSS A/S');
    }

    /** @test */
    public function partner_is_redirected_if_already_logged_in()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->be($user);

        $this->get(route('partner.signup'))
            ->assertRedirect(route('partner.dashboard'));
    }

    /** @test */
    function name_is_required_fail_without_input()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('name', '')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    function name_is_required_pass_with_input()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('name', 'Kim')
            ->call('registerPartnerAndUser')
            ->assertHasNoErrors(['name' => 'required']);
    }

    /** @test */
    function email_is_required_fail_with_no_input()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('email', '')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    function email_is_required_pass_with_correct_email()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('email', 'kontakt@kimlangholz.dk')
            ->call('registerPartnerAndUser')
            ->assertHasNoErrors(['email' => 'required']);
    }

    /** @test */
    function email_is_valid_email()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('email', 'contact')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    function email_hasnt_been_taken_already()
    {
        User::factory()->create(['email' => 'contact@partner.com']);

        Livewire::test('partner.auth.sign-up')
            ->set('email', 'contact@partner.com')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    function see_email_hasnt_already_been_taken_validation_message_as_user_types()
    {
        User::factory()->create(['email' => 'contact@partner.com']);

        Livewire::test('partner.auth.sign-up')
            ->set('email', 'contact@user.com')
            ->assertHasNoErrors()
            ->set('email', 'contact@partner.com')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    function password_is_required()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('password', '')
            ->set('passwordConfirmation', 'password')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    function password_is_minimum_of_eight_characters()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['password' => 'min']);
    }

    /** @test */
    function password_matches_password_confirmation()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('email', 'contact@partner.com')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'not-password')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['password' => 'same']);
    }

    /** @test */
    function phone_is_a_minimum_of_eight_characters()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('phone', '1234567')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['phone' => 'min']);
    }

    /** @test */
    function phone_is_ok_with_a_minimum_of_eight_characters()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('phone', '12345678')
            ->call('registerPartnerAndUser')
            ->assertHasNoErrors(['phone' => 'min']);
    }

    /** @test */
    function phone_is_required()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('phone', '')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['phone' => 'required']);
    }

    /** @test */
    function cvr_is_required()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('cvr', '')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['cvr' => 'required']);
    }

    /** @test */
    function cvr_is_not_valid_with_less_than_eight_characters()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('cvr', '1234567')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['cvr' => 'min']);
    }

    /** @test */
    function cvr_is_ok_with_exactly_eight_characters()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('cvr', '12345678')
            ->call('registerPartnerAndUser')
            ->assertHasNoErrors(['cvr' => 'min', 'cvr' => 'max']);
    }

    /** @test */
    function cvr_is_more_than_eight_characters()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('cvr', '123456789')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['cvr' => 'max']);
    }

    /** @test */
    function cvr_is_a_lot_more_than_eight_characters()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('cvr', '123456781231239')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['cvr' => 'max']);
    }

    /** @test */
    function company_name_is_required()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('company_name', '')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['company_name' => 'required']);
    }

    /** @test */
    function company_name_is_filled_out()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('company_name', 'Test firma')
            ->call('registerPartnerAndUser')
            ->assertHasNoErrors(['company_name' => 'required']);
    }

    /** @test */
    function company_address_is_required()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('company_address', '')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['company_address' => 'required']);
    }

    /** @test */
    function company_address_is_filled_out()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('company_address', 'Test firma')
            ->call('registerPartnerAndUser')
            ->assertHasNoErrors(['company_address' => 'required']);
    }

    /** @test */
    function zipcode_is_required()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('zipcode', '')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['zipcode' => 'required']);
    }

    /** @test */
    function zipcode_is_not_valid_with_less_than_0555()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('zipcode', 554)
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['zipcode' => 'between']);
    }

    /** @test */
    function zipcode_is_ok_with_lower_border_value()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('zipcode', 555)
            ->call('registerPartnerAndUser')
            ->assertHasNoErrors(['zipcode' => 'between']);
    }

    /** @test */
    function zipcode_is_ok_with_median_value()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('zipcode', 6400)
            ->call('registerPartnerAndUser')
            ->assertHasNoErrors(['zipcode' => 'between']);
    }

    /** @test */
    function zipcode_is_ok_with_upper_border_value()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('zipcode', 9999)
            ->call('registerPartnerAndUser')
            ->assertHasNoErrors(['zipcode' => 'between']);
    }

    /** @test */
    function zipcode_is_invalid_with_more_than_9999_as_value()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('zipcode', 10000)
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['zipcode' => 'between']);
    }

    /** @test */
    function zipcode_is_invalid_with_string_input()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('zipcode', 'ol1000')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['zipcode' => 'integer']);
    }

    /** @test */
    function city_is_required_fail_with_no_input()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('city', '')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['city' => 'required']);
    }

    /** @test */
    function city_is_required_pass_with_input()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('city', 'Sønderborg')
            ->call('registerPartnerAndUser')
            ->assertHasNoErrors(['city' => 'required']);
    }

    /** @test */
    function country_is_required_fail_with_no_input()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('country', '')
            ->call('registerPartnerAndUser')
            ->assertHasErrors(['country' => 'required']);
    }

    /** @test */
    function country_is_required_pass_with_input()
    {
        Livewire::test('partner.auth.sign-up')
            ->set('country', 'Danmark')
            ->call('registerPartnerAndUser')
            ->assertHasNoErrors(['country' => 'required']);
    }

    
}
