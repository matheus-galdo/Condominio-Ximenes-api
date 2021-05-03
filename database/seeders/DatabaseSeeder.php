<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
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
            'type' => 2,
            'email' => 'galdo',
            'password' => password_hash('galdo', PASSWORD_BCRYPT)
        ]);

        User::create([
            'name' => 'ablue',
            'type' => 1,
            'email' => 'ablue',
            'password' => password_hash('ablue', PASSWORD_BCRYPT)
        ]);

        $this->call([
            UserTypesSeeder::class
        ]);

    }
}
