<?php

namespace Tests\Feature;

use App\Http\Livewire\Partner\PartnerSettingsForm;
use Tests\BrowserTestCase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;


class PartnerSettingsTest extends BrowserTestCase
{
    /** @test */
    public function name_is_prefilled()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->visit('/partner/settings')
            ->see($user->name);
    }

    /** @test */
    public function email_is_prefilled()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->visit('/partner/settings')
            ->see($user->email);
    }

    /** @test */
    public function phone_is_prefilled()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        $this->visit('/partner/settings')
            ->see($user->phone);
    }

    /** @test */
    public function password_is_required_pass()
    {
        $this->actingAs(User::factory()->create(['role_id' => 3]));

        Livewire::test(PartnerSettingsForm::class)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('updateUserInfo')
            ->assertHasNoErrors(['password' => 'required']);
    }

    /** @test */
    public function password_regex_requires_at_least_one_capital_character_fail()
    {
        $this->actingAs(User::factory()->create(['role_id' => 3]));

        Livewire::test(PartnerSettingsForm::class)
            ->set('password', 'password1!')
            ->set('password_confirmation', 'password1!')
            ->call('updateUserInfo')
            ->assertHasErrors(['password' => 'regex'])
            ->assertSee('Dit kodeord matchede ikke ét eller flere af vores sikkerhedskrav.');
    }

    /** @test */
    public function password_regex_requires_at_least_one_lower_case_character_fail()
    {
        $this->actingAs(User::factory()->create(['role_id' => 3]));

        Livewire::test(PartnerSettingsForm::class)
            ->set('password', 'PASSWORD1!')
            ->set('password_confirmation', 'PASSWORD1!')
            ->call('updateUserInfo')
            ->assertHasErrors(['password' => 'regex'])
            ->assertSee('Dit kodeord matchede ikke ét eller flere af vores sikkerhedskrav.');
    }

    /** @test */
    public function password_regex_requires_at_least_one_number_fail()
    {
        $this->actingAs(User::factory()->create(['role_id' => 3]));

        Livewire::test(PartnerSettingsForm::class)
            ->set('password', 'Password!')
            ->set('password_confirmation', 'Password!')
            ->call('updateUserInfo')
            ->assertHasErrors(['password' => 'regex'])
            ->assertSee('Dit kodeord matchede ikke ét eller flere af vores sikkerhedskrav.');
    }

    /** @test */
    public function password_regex_requires_at_least_one_special_character_fail()
    {
        $this->actingAs(User::factory()->create(['role_id' => 3]));

        Livewire::test(PartnerSettingsForm::class)
            ->set('password', 'Passw0rd')
            ->set('password_confirmation', 'Passw0rd')
            ->call('updateUserInfo')
            ->assertHasErrors(['password' => 'regex'])
            ->assertSee('Dit kodeord matchede ikke ét eller flere af vores sikkerhedskrav.');
    }

    /** @test */
    public function password_regex_all_demands_fulfilled_pass()
    {
        $this->actingAs(User::factory()->create(['role_id' => 3]));

        Livewire::test(PartnerSettingsForm::class)
            ->set('password', 'Passw0rd!')
            ->set('password_confirmation', 'Passw0rd!')
            ->call('updateUserInfo')
            ->assertHasNoErrors(['password' => 'regex'])
            ->assertDontSee('Dit kodeord matchede ikke ét eller flere af vores sikkerhedskrav.')
            ->assertDontSee('Dit kodeords længde var ikke på minimum 8 karakterer.')
            ->assertDontSee('Kodeordene var ikke ens.');
    }

    /** @test */
    public function password_with_less_than_8_characters_fail()
    {
        $this->actingAs(User::factory()->create(['role_id' => 3]));

        Livewire::test(PartnerSettingsForm::class)
            ->set('password', 'Pass1!')
            ->set('password_confirmation', 'Pass1!')
            ->call('updateUserInfo')
            ->assertHasErrors(['password' => 'min'])
            ->assertSee('Dit kodeords længde var ikke på minimum 8 karakterer.');
    }

    /** @test */
    public function password_with_8_characters_pass()
    {
        $this->actingAs(User::factory()->create(['role_id' => 3]));

        Livewire::test(PartnerSettingsForm::class)
            ->set('password', 'Passwo1!')
            ->set('password_confirmation', 'Passwo1!')
            ->call('updateUserInfo')
            ->assertHasNoErrors(['password' => 'min'])
            ->assertDontSee('Dit kodeords længde var ikke på minimum 8 karakterer.');
    }

    /** @test */
    public function password_with_more_than_8_characters_pass()
    {
        $this->actingAs(User::factory()->create(['role_id' => 3]));

        Livewire::test(PartnerSettingsForm::class)
            ->set('password', 'Password1!')
            ->set('password_confirmation', 'Password1!')
            ->call('updateUserInfo')
            ->assertHasNoErrors(['password' => 'min'])
            ->assertDontSee('Dit kodeords længde var ikke på minimum 8 karakterer.')
            ->assertSee('Bruger info er opdateret.');
    }

    /** @test */
    public function password_not_equal_fail()
    {
        $this->actingAs(User::factory()->create(['role_id' => 3]));

        Livewire::test(PartnerSettingsForm::class)
            ->set('password', 'Password1!')
            ->set('password_confirmation', 'pAssword1!')
            ->call('updateUserInfo')
            ->assertHasErrors(['password' => 'confirmed'])
            ->assertSee('Kodeordene var ikke ens.');
    }

    /** @test */
    public function password_is_equal_pass()
    {
        $user = User::factory()->create(['role_id' => 3]);
        $this->actingAs($user);

        Livewire::test(PartnerSettingsForm::class)
            ->set('password', 'Password1!')
            ->set('password_confirmation', 'Password1!')
            ->call('updateUserInfo')
            ->assertHasNoErrors(['password' => 'confirmed'])
            ->assertDontSee('Kodeordene var ikke ens.');
    }

    /** @test */
    public function cvr_is_required_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('cvr', '')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['cvr' => 'required'])
            ->assertSee('Der skal indtastes et CVR nummer.')
            ->assertDontSee('Virksomhedsinfo er opdateret.');
    }

    /** @test */
    public function cvr_is_required_pass()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('cvr', '12345678')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['cvr' => 'required'])
            ->assertDontSee('Der skal indtastes et CVR nummer.');
    }

    /** @test */
    public function cvr_regex_validation_contains_letter_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('cvr', '1234s678')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['cvr' => 'regex'])
            ->assertSee('CVR nummeret skal kun indeholde tal og være 8 cifre langt.')
            ->assertDontSee('Virksomhedsinfo er opdateret.');
    }

    /** @test */
    public function cvr_regex_validation_contains_no_numbers_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('cvr', 'asfkolajsf')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['cvr' => 'regex'])
            ->assertSee('CVR nummeret skal kun indeholde tal og være 8 cifre langt.')
            ->assertDontSee('Virksomhedsinfo er opdateret.');
    }

    /** @test */
    public function cvr_regex_validation_contains_less_than_8_digits_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('cvr', '1234567')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['cvr' => 'regex'])
            ->assertSee('CVR nummeret skal kun indeholde tal og være 8 cifre langt.')
            ->assertDontSee('Virksomhedsinfo er opdateret.');
    }

    /** @test */
    public function cvr_regex_validation_contains_more_than_8_digits_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('cvr', '123456789')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['cvr' => 'regex'])
            ->assertSee('CVR nummeret skal kun indeholde tal og være 8 cifre langt.')
            ->assertDontSee('Virksomhedsinfo er opdateret.');
    }

    /** @test */
    public function cvr_regex_validation_pass()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('cvr', '12345678')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['cvr' => 'regex'])
            ->assertDontSee('CVR nummeret skal kun indeholde tal og være 8 cifre langt.');
    }

    /** @test */
    public function company_name_required_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_name', '')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['company_name' => 'required'])
            ->assertSee('Et virksomhedsnavn er påkrævet.');
    }

    /** @test */
    public function company_name_required_pass()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_name', 'Partform ApS')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['company_name' => 'required'])
            ->assertDontSee('Et virksomhedsnavn er påkrævet.');
    }

    /** @test */
    public function company_address_required_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_address', '')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['company_address' => 'required'])
            ->assertSee('Virksomheden skal angive en adresse.');
    }

    /** @test */
    public function company_address_required_pass()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_address', 'Stenderup 17')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['company_address' => 'required'])
            ->assertDontSee('Virksomheden skal angive en adresse.');
    }

    /** @test */
    public function zipcode_required_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('zipcode', '')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['zipcode' => 'required'])
            ->assertSee('Et postnummer er påkrævet.');
    }

    /** @test */
    public function zipcode_required_pass()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('zipcode', '6400')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['zipcode' => 'required'])
            ->assertDontSee('Et postnummer er påkrævet.');
    }

    /** @test */
    public function zipcode_regex_contains_letter_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('zipcode', '530o')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['zipcode' => 'regex'])
            ->assertSee('Postnummeret kan kun bestå af tal og skal være 3-4 cifre langt.');
    }

    /** @test */
    public function zipcode_regex_contains_less_than_3_numbers()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('zipcode', '53')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['zipcode' => 'regex'])
            ->assertSee('Postnummeret kan kun bestå af tal og skal være 3-4 cifre langt.');
    }

    /** @test */
    public function zipcode_regex_contains_more_than_4_numbers()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('zipcode', '53000')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['zipcode' => 'regex'])
            ->assertSee('Postnummeret kan kun bestå af tal og skal være 3-4 cifre langt.');
    }

    /** @test */
    public function zipcode_regex_contains_only_digits_pass()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('zipcode', '6400')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['zipcode' => 'regex'])
            ->assertDontSee('Postnummeret kan kun bestå af tal og skal være 3-4 cifre langt.');
    }

    /** @test */
    public function zipcode_regex_contains_approved_number_of_digits()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('zipcode', '640')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['zipcode' => 'regex'])
            ->assertDontSee('Postnummeret kan kun bestå af tal og skal være 3-4 cifre langt.');
    }

    /** @test */
    public function city_required_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('city', '')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['city' => 'required'])
            ->assertSee('En by angivelse er påkrævet.');
    }

    /** @test */
    public function city_required_pass()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('city', '6400')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['city' => 'required'])
            ->assertDontSee('En by angivelse er påkrævet.');
    }

    /** @test */
    public function country_required_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('country', '')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['country' => 'required'])
            ->assertSee('En lande-angivelse er påkrævet.');
    }

    /** @test */
    public function country_required_pass()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('country', 'Danmark')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['country' => 'required'])
            ->assertDontSee('En lande-angivelse er påkrævet.');
    }

    /** @test */
    public function company_capital_regex__contains_letter_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_capital', '500000 kroner')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['company_capital' => 'regex'])
            ->assertSee('Egenkapitalen skal udelukkende bestå af tal.');
    }

    /** @test */
    public function company_capital_regex_contains_special_character_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_capital', '500.000,00')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['company_capital' => 'regex'])
            ->assertSee('Egenkapitalen skal udelukkende bestå af tal.');
    }

    /** @test */
    public function company_capital_regex_is_more_than_13_digits_long_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_capital', '10000000000000')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['company_capital' => 'regex'])
            ->assertSee('Egenkapitalen skal udelukkende bestå af tal.');
    }

    /** @test */
    public function company_capital_regex_pass()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_capital', '500000')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['company_capital' => 'regex'])
            ->assertDontSee('Egenkapitalen skal udelukkende bestå af tal.');
    }

    /** @test */
    public function company_number_of_employees_regex_contains_letter_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_number_of_employees', '1200 personer')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['company_number_of_employees' => 'regex'])
            ->assertSee('Indtastningen skal udelukkende bestå af tal.');
    }

    /** @test */
    public function company_number_of_employees_regex_contains_special_character_fail()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_number_of_employees', '1200,5')
            ->call('updateCompanyInfo')
            ->assertHasErrors(['company_number_of_employees' => 'regex'])
            ->assertSee('Indtastningen skal udelukkende bestå af tal.');
    }

    /** @test */
    public function company_number_of_employees_regex_pass()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_number_of_employees', '23')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['company_number_of_employees' => 'regex'])
            ->assertDontSee('Indtastningen skal udelukkende bestå af tal.');
    }

    /** @test */
    public function company_number_of_employees_regex_with_null_pass()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('company_number_of_employees', '')
            ->call('updateCompanyInfo')
            ->assertHasNoErrors(['company_number_of_employees' => 'regex'])
            ->assertDontSee('Indtastningen skal udelukkende bestå af tal.');
    }

    /** @test */
    public function can_user_update_password()
    {
        $user = User::factory()->create(['role_id' => 3]);

        Livewire::actingAs($user)
            ->test(PartnerSettingsForm::class)
            ->set('password', 'Password1!')
            ->set('password_confirmation', 'Password1!')
            ->call('updateUserInfo')
            ->assertSee('Bruger info er opdateret.');
    }

    /** @test */
    public function can_user_update_user_profile_with_new_user_info()
    {
        $user = User::factory()->create(['role_id' => 3]);

        Livewire::actingAs($user)
            ->test(PartnerSettingsForm::class)
            ->set('name', 'Kim Langholz')
            ->set('email', 'kontakt@testemail.dk')
            ->set('phone', '12345678')
            ->set('password', 'Passw0rd1.')
            ->set('password_confirmation', 'Passw0rd1.')
            ->call('updateUserInfo')
            ->assertSee('Bruger info er opdateret.');
    }

    /** @test */
    public function can_user_update_company_profile_with_new_company_info()
    {
        Livewire::actingAs(User::factory()->create(['role_id' => 3]))
            ->test(PartnerSettingsForm::class)
            ->set('cvr', '12345678')
            ->set('company_name', 'Partform ApS')
            ->set('company_address', 'Stenderup 17')
            ->set('zipcode', '6400')
            ->set('city', 'Sønderborg')
            ->set('country', 'Danmark')
            ->set('company_phone', '42683939')
            ->set('company_start_date', '01-01-2019')
            ->set('company_capital', '50000')
            ->set('company_number_of_employees', '5')
            ->call('updateCompanyInfo')
            ->assertSee('Virksomhedsinfo er opdateret.');
    }

    /** @test */
    public function can_user_upload_png_certificate()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('certificate.png');

        $user = User::factory()->create(['role_id' => 3]);
        $company = Partner::where('id', $user['company_id'])->firstOrFail();

        $fileName = Str::random(44);

        Livewire::actingAs($user)
            ->test(PartnerSettingsForm::class)
            ->set('certificate_name', 'ISO 10300')
            ->set('certificate_valid_until', '12/31/2021')
            ->set('certificate_file', $file)
            ->call('uploadCertificate', $fileName);

        Storage::disk('local')->assertExists('certifications/company_id-' . $company['id'] . '/' . $fileName . '.png');
    }

    /** @test */
    public function can_user_upload_jpeg_certificate()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('certificate.jpeg');

        $user = User::factory()->create(['role_id' => 3]);
        $company = Partner::where('id', $user['company_id'])->firstOrFail();

        $fileName = Str::random(44);

        Livewire::actingAs($user)
            ->test(PartnerSettingsForm::class)
            ->set('certificate_name', 'ISO 10300')
            ->set('certificate_valid_until', '12/31/2021')
            ->set('certificate_file', $file)
            ->call('uploadCertificate', $fileName);

        Storage::disk('local')->assertExists('certifications/company_id-' . $company['id'] . '/' . $fileName . '.jpeg');
    }

    /** @test */
    public function can_user_upload_jpg_certificate()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('certificate.jpg');

        $user = User::factory()->create(['role_id' => 3]);
        $company = Partner::where('id', $user['company_id'])->firstOrFail();

        $fileName = Str::random(44);

        Livewire::actingAs($user)
            ->test(PartnerSettingsForm::class)
            ->set('certificate_name', 'ISO 10300')
            ->set('certificate_valid_until', '12/31/2021')
            ->set('certificate_file', $file)
            ->call('uploadCertificate', $fileName);

        Storage::disk('local')->assertExists('certifications/company_id-' . $company['id'] . '/' . $fileName . '.jpeg');
    }

    /** @test */
    public function can_user_upload_pdf_certificate()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->create('certificate.pdf');

        $user = User::factory()->create(['role_id' => 3]);
        $company = Partner::where('id', $user['company_id'])->firstOrFail();

        $fileName = Str::random(44);

        Livewire::actingAs($user)
            ->test(PartnerSettingsForm::class)
            ->set('certificate_name', 'ISO 10300')
            ->set('certificate_valid_until', '12/31/2021')
            ->set('certificate_file', $file)
            ->call('uploadCertificate', $fileName);

        Storage::disk('local')->assertExists('certifications/company_id-' . $company['id'] . '/' . $fileName . '.pdf');
    }

    /** @test */
    public function can_user_upload_invalid_certificate_filetype()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->create('certificate.txt');

        $user = User::factory()->create(['role_id' => 3]);
        $company = Partner::where('id', $user['company_id'])->firstOrFail();

        $fileName = Str::random(44);

        Livewire::actingAs($user)
            ->test(PartnerSettingsForm::class)
            ->set('certificate_name', 'ISO 10300')
            ->set('certificate_valid_until', '12/31/2021')
            ->set('certificate_file', $file)
            ->call('uploadCertificate', $fileName)
            ->assertHasErrors(['certificate_file' => 'mimes']);

        Storage::disk('local')->assertMissing('certifications/company_id-' . $company['id'] . '/' . $fileName . '.txt');
    }

    /** @test */
    public function can_user_upload_see_and_delete_a_certificate()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->create('certificate.pdf');

        $this->actingAs(User::factory()->create(['role_id' => 3]));

        $fileName = Str::random(44);

        Livewire::test(PartnerSettingsForm::class)
            ->set('certificate_name', 'ISO 10300')
            ->set('certificate_valid_until', '12/31/2021')
            ->set('certificate_file', $file)
            ->call('uploadCertificate', $fileName);

        $this->visit('/partner/settings')
            ->see('ISO 10300');

        Livewire::test(PartnerSettingsForm::class)
            ->call('deleteCertificate', 'ISO 10300')
            ->assertRedirect(route('partner.settings'));
    }
}
