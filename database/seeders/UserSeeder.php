<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->admins as $admin) {
            User::factory($admin)->create();
        }

        User::factory()
            ->times(5)
            ->create();
    }

    private $admins = [
        [
            'name' => 'Kim Langholz',
            'email' => 'kontakt@kimlangholz.dk',
            'role_id' => 3,
            'password' => '$2y$10$p5Hjg4h6ouNrjf/Y/PKZyeC6RBEO1yM2Irpbc9oCl8Dstu.PYGM0G' //password
        ],
        [
            'name' => 'Allan Brink',
            'email' => 'allanbrink@hotmail.com',
            'role_id' => 3,
            'password' => '$2y$10$p5Hjg4h6ouNrjf/Y/PKZyeC6RBEO1yM2Irpbc9oCl8Dstu.PYGM0G' //password
        ],
    ];
}
