<?php

namespace Database\Seeders;

use App\Models\Apartamento;
use Illuminate\Database\Seeder;

class ApartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Apartamento::factory(10)->create();

        // \App\Models\User::factory(10)->create();

    }
}
