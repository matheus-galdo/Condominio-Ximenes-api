<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersSeeds = [
            ['name' => 'Admin', 'type' => 1, 'email' => 'admin'],
            ['name' => 'Teste', 'type' => 1, 'email' => 'teste'],
            ['name' => 'Galdino', 'type' => 2, 'email' => 'galdo'],
        ];

        foreach ($usersSeeds as $key => $value) {
            User::create([
                'name' => $value['name'],
                'type' => $value['type'],
                'email' => $value['email'],
                'password' => password_hash($value['email'], PASSWORD_BCRYPT)
            ]);
        }
    }
}
