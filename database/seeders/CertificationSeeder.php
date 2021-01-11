<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certification;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->certificates as $certificate) {
            Certification::create($certificate);
        }
    }

    private $certificates = [
        ['certification_name' => 'ISO 9001'],
        ['certification_name' => 'ISO 9002'],
        ['certification_name' => 'ISO 9003'],
        ['certification_name' => 'ISO 9004'],
        ['certification_name' => 'ISO 9005']
    ];
}
