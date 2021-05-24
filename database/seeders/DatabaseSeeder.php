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
        $this->call([
            //dados essenciais do sistema
            OcorrenciaEventosFollowupSeeder::class,
            ModulosSistemaSeeder::class,

            //instancias iniciais
            UserTypesSeeder::class,
            UsersSeeder::class,
            
            //instancias para debug dos modulos
            PermissoesSeeder::class,
            ApartamentosSeeder::class,
            ProprietariosSeeder::class,
            ModulosTextosSeeder::class
        ]);

    }
}
