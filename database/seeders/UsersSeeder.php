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
        User::create([
            'name' => 'Admin',
            'type' => 1,
            'email' => 'admin',
            'password' => password_hash('admin', PASSWORD_BCRYPT)
        ]);

        User::create([
            'name' => 'teste',
            'type' => 1,
            'email' => 'teste',
            'password' => password_hash('teste', PASSWORD_BCRYPT)
        ]);

        User::create([
            'name' => 'galdo',
            'type' => 4,
            'email' => 'galdo',
            'password' => password_hash('galdo', PASSWORD_BCRYPT)
        ]);

        User::create([
            'name' => 'ablue',
            'type' => 1,
            'email' => 'ablue',
            'password' => password_hash('ablue', PASSWORD_BCRYPT)
        ]);
    }
}
