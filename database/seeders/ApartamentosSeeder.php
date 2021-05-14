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

        for ($i=1; $i <= 8; $i++) { 
            $andar = rand(1, 8);
            Apartamento::create([
                'bloco' => ($andar <= 4)? 'A': 'B',
                'numero' => "{$andar}{$i}",
                'andar' => $andar
            ]);      
        }
        // Apartamento::factory(10)->create();

    }
}
