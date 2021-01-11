<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class PartnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Partner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create('da_DK');
        return [
            'cvr' => $faker->numberBetween($min = 10000000, $max = 99999999),
            'company_name' => $faker->unique()->company,
            'company_address' => $faker->streetAddress,
            'zipcode_id' => $faker->numberBetween($min = 1, $max = 600),
            'country_id' => 1,
            'phone' => $faker->phoneNumber,
            'start_date' => $faker->date('d-m-Y'),
            'capital' => $faker->numberBetween($min = 0, $max = 15000000),
        ];
    }
}

