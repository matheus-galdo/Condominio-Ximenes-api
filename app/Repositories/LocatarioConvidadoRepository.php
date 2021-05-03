<?php

namespace App\Repositories;

use App\Models\Locatario;
use App\Models\LocatarioConvidado;
use App\Models\LocatarioVeiculo;

class LocatarioConvidadoRepository
{

    public static function create($convidado, $locatario)
    {
        LocatarioConvidado::create([
            'nome' => $convidado['nomeConvidado']['value'],
            'cpf' => clearCpf($convidado['cpf']['value']),
            'celular' => $convidado['celular']['value'],
            'email' => $convidado['email']['value'],
            'observacoes' => $convidado['observacoes']['value'],
            'locatario_id' => $locatario->id
        ]);
    }
}
