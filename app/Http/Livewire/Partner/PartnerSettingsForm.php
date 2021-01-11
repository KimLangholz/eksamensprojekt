<?php

namespace App\Http\Livewire\Partner;

use Livewire\Component;
use App\Models\Zipcode;
use App\Models\Country;
use App\Models\Partner;
use App\Models\Certification;
use App\Models\CertificationPartner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PartnerSettingsForm extends Component
{
    use WithFileUploads;

    /** @var string */
    public $name = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $phone = '';

    /** @var string */
    public $password;

    /** @var string */
    public $password_confirmation;

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

    public $company_phone;

    public $company_start_date;

    public $company_capital;

    public $company_number_of_employees;

    public $all_certifications_list = [];

    public $certification_list = [];

    public $certifications;

    public $certificate_file;

    public $certificate_name;

    public $certificate_date;

    public $certificate_valid_until;

    public $user;

    public $company;

    public $passwordHasBeenUpdated = false;

    private $fileName;

    public $requestDelete = false;

    public $requestDeleteCertificateName;

    public $userInfoSuccessMessage;

    public $companySuccessMessage;

    protected $userRules = [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required|min:8'
    ];

    protected $passwordRules = [
        'password' => 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!.,@#\$%\^&\*]).*$/|min:8|confirmed',
    ];

    protected $companyRules = [
        'cvr' => 'required|regex:/^[0-9]{8}$/',
        'company_name' => 'required',
        'company_address' => 'required',
        'zipcode' => 'required|regex:/^[0-9]{3,4}$/',
        'city' => 'required',
        'country' => 'required',
        'company_capital' => 'regex:/^[0-9]{0,13}$/',
        'company_number_of_employees' => ['regex:/^(?:[0-9]*|)$/'],
    ];

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Der skal indtastes et navn.',
            'email.required' => 'Der skal indtastes en email.',
            'email.email' => 'Email formattet blev ikke godkendt.',
            'phone.required' => 'Der skal indtastes et telefonnummer.',
            'phone.min' => 'Telefonnummeret skal være på min. 8 cifre.',
            'password.regex' => 'Dit kodeord matchede ikke ét eller flere af vores sikkerhedskrav.',
            'password.min' => 'Dit kodeords længde var ikke på minimum 8 karakterer.',
            'password.confirmed' => 'Kodeordene var ikke ens.',
            'cvr.required' => 'Der skal indtastes et CVR nummer.',
            'cvr.regex' => 'CVR nummeret skal kun indeholde tal og være 8 cifre langt.',
            'company_name.required' => 'Et virksomhedsnavn er påkrævet.',
            'company_address.required' => 'Virksomheden skal angive en adresse.',
            'zipcode.required' => 'Et postnummer er påkrævet.',
            'zipcode.regex' => 'Postnummeret kan kun bestå af tal og skal være 3-4 cifre langt.',
            'city.required' => 'En by angivelse er påkrævet.',
            'country.required' => 'En lande-angivelse er påkrævet.',
            'company_capital.regex' => 'Egenkapitalen skal udelukkende bestå af tal.',
            'company_number_of_employees.regex' => 'Indtastningen skal udelukkende bestå af tal.',
        ];
    }

    public function update($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->user = auth()->user();
        $this->company = Partner::where('id', $this->user['company_id'])->firstOrFail();

        $this->certificate_file = null;
        $this->certification_list = [];
        $this->all_certifications_list = [];
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->cvr = $this->company->cvr;
        $this->company_name = $this->company->company_name;
        $this->company_address = $this->company->company_address;
        $this->zipcode = $this->company->zipcode->zipcode;
        $this->city = $this->company->zipcode->city;
        $this->country = $this->company->country->country;
        $this->company_phone = $this->company->phone;
        $this->company_start_date = $this->company->start_date;
        $this->company_capital = $this->company->capital;
        $this->company_number_of_employees = $this->company->number_of_employees;

        $this->requestDelete = false;
        $this->requestDeleteCertificateName = null;
        $this->userInfoSuccessMessage = null;
        $this->companySuccessMessage = null;

        foreach (Certification::get()->pluck('certification_name') as $certificate) {
            $this->all_certifications_list[] = $certificate;
        }

        $certifications = Partner::find($this->company['id'])->certifications;

        foreach (CertificationPartner::where('partner_id', $this->company['id'])->get() as $certificate) {
            $this->certification_list[] = [
                'certification_name' => $certifications->where('id', $certificate['certification_id'])->pluck('certification_name')[0],
                'certification_last_edited_date' => $certificate['updated_at']->toDateString(),
                'certification_valid_until' => $certificate['valid_until'],
            ];
        }
    }

    public function updateUserInfo()
    {
        $this->validate($this->userRules);

        $this->user->name = $this->name;
        $this->user->email = strtolower($this->email);
        $this->user->phone = trim($this->phone);

        if (strlen($this->password) > 1 && strlen($this->password_confirmation) > 1) {
            $this->validate($this->passwordRules);
            $this->user->password = Hash::make($this->password);
            $this->passwordHasBeenUpdated = true;
        }
        $this->user->save();

        $this->userInfoSuccessMessage = 'Bruger info er opdateret.';
    }


    public function updateCompanyInfo()
    {
        $this->validate($this->companyRules);

        $this->company->cvr = $this->cvr;
        $this->company->company_name = $this->company_name;
        $this->company->company_address = $this->company_address;
        $this->company->zipcode_id = Zipcode::where('zipcode', $this->zipcode)->first()->id;
        $this->company->country_id = Country::where('country', $this->country)->first()->id;
        $this->company->phone = $this->company_phone;
        $this->company->start_date = $this->company_start_date;
        $this->company->capital = $this->company_capital;
        $this->company->number_of_employees = $this->company_number_of_employees;

        $this->company->save();

        $this->companySuccessMessage = 'Virksomhedsinfo er opdateret.';
    }

    public function uploadCertificate($fileName)
    {

        $this->fileName = $fileName;

        $this->validateAndStoreCertificate($this->certificate_file);

        $convertedCertificationName = strtoupper($this->certificate_name);

        if (!in_array($convertedCertificationName, $this->all_certifications_list)) {
            Certification::create(['certification_name' => $convertedCertificationName]);
        }

        $certificate_partner_id = Certification::where('certification_name', $convertedCertificationName)->pluck('id')->first();

        CertificationPartner::create([
            'partner_id' => $this->company['id'],
            'certification_id' => $certificate_partner_id,
            'valid_until' =>  $this->certificate_valid_until,
            'file_path' => 'certifications/company_id-' . $this->company['id'] . '/' . $this->fileName
        ]);
        
        foreach (CertificationPartner::where('partner_id', 15)->where('certification_id', $certificate_partner_id)->get() as $certificate) {
            $this->certification_list[] = [
                'certification_name' => Partner::find($this->company['id'])->certifications->where('id', $certificate['certification_id'])->pluck('certification_name')[0],
                'certification_last_edited_date' => $certificate['updated_at']->toDateString(),
                'certification_valid_until' => $certificate['valid_until'],
            ];
        }
    }

    public function confirmCertificateDeleteAction($certification_name)
    {
        $this->requestDeleteCertificateName = $certification_name;
        $this->requestDelete = true;
    }

    public function deleteCertificate($certification_name)
    {
        $certificate_partner_id = Certification::where('certification_name', $certification_name)->pluck('id')->first();

        CertificationPartner::where('partner_id', $this->company['id'])->where('certification_id', $certificate_partner_id)->delete();

        redirect(route('partner.settings'));
    }

    private function validateAndStoreCertificate($file)
    {
        $this->validate([
            'certificate_file' => 'mimes:jpeg,jpg,png,pdf'
        ]);

        if (!Storage::directories('certifications/company_id-' . $this->company['id'] . '/')) {
            Storage::makeDirectory('certifications/company_id-' . $this->company['id'] . '/');
        }

        $file->storeAs('certifications/company_id-' . $this->company['id'] . '/',
                        $this->fileName . '.' . $this->certificate_file->getClientOriginalExtension(),
                        $disk = 'local'
                    );
    }

    public function resetMessage()
    {
        $this->userInfoSuccessMessage = null;
        $this->companySuccessMessage = null;
    }

    public function render()
    {
        return view('livewire.partner.partner-settings-form');
    }
}
