<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->countries as $country) {
            Country::create($country);
        }
    }

    private $countries = [
        [
            'country' => 'Danmark',
        ]
    ];
}
