<?php

namespace Database\Seeders;

use App\Models\EventoFollowup;
use Illuminate\Database\Seeder;

class OcorrenciaEventosFollowupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventos = [
            'aberta',
            'em andamento',
            'avançou',
            'finalizando',
            'aguardando',
            'cancelada',
            'concluída'
        ];

        foreach ($eventos as $evento) {
            EventoFollowup::create([
                'nome' => $evento
            ]);
        }
    }
}
