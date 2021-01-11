<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Client;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create('en_US');
        $role_id = random_int(2, 3);
        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'phone' => $faker->phoneNumber,
            'company_id' => $this->findCompanyId($role_id),
            'role_id' => $role_id,
            'company_type' => $this->returnCompanyType($role_id),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }



    private function findCompanyId($role_id)
    {
        if ($role_id === 3) {

            if(Client::count() === 0){
                return 1;
            }
            return random_int(1, Client::count());

        }
        if(Partner::count() === 0){
            return 1;
        }
        return random_int(1, Partner::count());
    }

    private function returnCompanyType($role_id)
    {
        if ($role_id === 3) {
            return 'App\Models\Client';
        }
        return 'App\Models\Partner';
    }
}
