<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::create([
            'type' => 'admin'
        ]);

        UserType::create([
            'type' => 'sindica'
        ]);

        UserType::create([
            'type' => 'porteiro'
        ]);

        UserType::create([
            'type' => 'morador'
        ]);
    }
}
