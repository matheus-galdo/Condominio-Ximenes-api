<?php

namespace App\Repositories;

use App\Models\Locatario;
use App\Models\LocatarioConvidado;
use App\Models\LocatarioVeiculo;

class LocatarioRepository{

    public static function createLocatario($request)
    {

        try {
            $hasVeiculos =(count($request->veiculos) > 0);
            $hasConvidados = (count($request->convidados) > 0);
            
            $locatario = Locatario::create([
                'nome' => $request->nomeLocatario,
                'cpf' => clearCpf($request->cpf),
                'data_chegada' => $request->dataChegada,
                'data_saida' => $request->dataSaida,
                'celular' => $request->celular,
                'email' => $request->email,
                'observacoes' => $request->observacoes,
                'possui_veiculos' => $hasVeiculos, 
                'possui_convidados' => $hasConvidados,
                'user_id' => auth()->user()->id
            ]);


            foreach ($request->veiculos as $veiculo) {
                LocatarioVeiculoRepository::create($veiculo, $locatario);
            }

            foreach ($request->convidados as $convidado) {
                LocatarioConvidadoRepository::create($convidado, $locatario);
            }

            return true;
        } catch (\Throwable $th) {

            return ['error' => $th];
        }
        
    }
}