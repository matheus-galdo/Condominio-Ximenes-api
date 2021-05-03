<?php

namespace App\Repositories;

use App\Models\Locatario;
use App\Models\LocatarioConvidado;
use App\Models\LocatarioVeiculo;

class LocatarioVeiculoRepository
{

    public static function create($veiculo, $locatario)
    {
        LocatarioVeiculo::create([
            'placa' => $veiculo['placa']['value'],
            'modelo' => $veiculo['modelo']['value'],
            'cor' => $veiculo['cor']['value'],
            'locatario_id' => $locatario->id
        ]);
    }
}
