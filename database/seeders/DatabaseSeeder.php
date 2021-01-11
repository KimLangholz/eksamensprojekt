<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            RoleSeeder::class,
            CountrySeeder::class,
            ZipcodeSeeder::class,
            CertificationSeeder::class,
            PartnerSeeder::class,
            CertificationPartnerSeeder::class,
            ClientSeeder::class,
            UserSeeder::class,
        ]);
    }
}
