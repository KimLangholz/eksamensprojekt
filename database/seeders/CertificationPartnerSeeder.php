<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;
use App\Models\Certification;
use App\Models\CertificationPartner;

class CertificationPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $partners = Partner::all();
        foreach($partners as $partner){

            $randomNumberOfCertifications = $this->getRandomNumberBasedOnNumberOfCertifications();
            $usedNumbers = [];

            for($value = 0; $value != $randomNumberOfCertifications; $value++){

                $certifcation_id = $this->getRandomNumberBasedOnNumberOfCertifications();
                while(in_array($certifcation_id, $usedNumbers))
                {
                    $certifcation_id = $this->getRandomNumberBasedOnNumberOfCertifications();
                }

                $usedNumbers[] = $certifcation_id;


                CertificationPartner::create([
                    'partner_id' => $partner->id,
                    'certification_id' => $usedNumbers[$value],
                    'valid_until' => '2022-12-31'
                    ]);
            }
        };
    }

    private function getRandomNumberBasedOnNumberOfCertifications(){
        return random_int(1, Certification::count());
    }
}
