<?php

namespace Database\Seeders;

use App\Models\Sistema\UserType;
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
        $types = [
            'admin',
            'sindica',
            'porteiro',
            'morador',
        ];

        foreach ($types as $type) {
            UserType::create([
                'nome' => $type,
                'is_admin' => !($type == 'morador'),
                'default_admin' => ($type == 'admin'),
                'default_user' => ($type == 'morador')
            ]);
        }
    }
}
