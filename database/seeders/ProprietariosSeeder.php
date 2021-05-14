<?php

namespace Database\Seeders;

use App\Models\ApartamentosProprietario;
use App\Models\Proprietario;
use Illuminate\Database\Seeder;

class ProprietariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proprietario::create([
            'user_id' => 3,
            'aprovado' => true,
            'telefone' => '123456',
        ]);


        ApartamentosProprietario::create([
            'proprietario_id' => 1,
            'apartamento_id' => 3
        ]);
    }
}
