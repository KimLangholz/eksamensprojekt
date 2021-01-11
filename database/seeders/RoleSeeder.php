<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    private $roles = [
        ['role' => 'Administrator'],
        ['role' => 'Partner'],
        ['role' => 'Client'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $role) {
            Role::create($role);
        }
    }


}
