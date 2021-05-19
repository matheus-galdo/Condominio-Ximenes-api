<?php

namespace Database\Seeders;

use App\Models\Ocorrencia\EventoFollowup;
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
            ['nome' => 'Nova ocorrência', 'cor' => '#1094ff'],
            ['nome' => 'Em andamento', 'cor' => '#22ccb5'],
            ['nome' => 'Em análise', 'cor' => '#ff9100'],
            ['nome' => 'Avançou', 'cor' => '#22ccb5'],
            ['nome' => 'Finalizando', 'cor' => '#22cc6f'],
            ['nome' => 'Aguardando', 'cor' => '#fdda16'],
            ['nome' => 'Cancelada', 'cor' => '#f02c2c'],
            ['nome' => 'Reaberta', 'cor' => '#ffd900'],
            ['nome' => 'Concluída', 'cor' => '#20bd42']
        ];

        foreach ($eventos as $evento) {
            EventoFollowup::create([
                'nome' => $evento['nome'],
                'cor' => $evento['cor']
            ]);
        }
    }
}
