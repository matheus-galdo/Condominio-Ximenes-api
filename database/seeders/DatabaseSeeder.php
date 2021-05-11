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
            UsersSeeder::class,
            UserTypesSeeder::class,
            OcorrenciaEventosFollowupSeeder::class,
            ModulosSistemaSeeder::class,
            PermissoesSeeder::class,
            ApartamentosSeeder::class
        ]);

    }
}
