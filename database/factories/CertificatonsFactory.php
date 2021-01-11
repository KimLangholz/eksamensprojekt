<?php

namespace Database\Factories;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class CertificatonsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Certificate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create('da_DK');
        $certificate_id = random_int(0, 4);
        return [
            'certificate_name' => $this->certificates[$certificate_id],
        ];
    }

    private $certificates = [
        'ISO 9001',
        'ISO 9002',
        'ISO 9003',
        'ISO 9004',
        'ISO 9005'
    ];


}
