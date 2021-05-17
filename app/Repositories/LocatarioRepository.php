<?php

namespace App\Repositories;

use App\Models\Locatario;
use App\Models\User;

class LocatarioRepository
{

    public static function createLocatario($request)
    {

        try {
            $user = User::find(auth()->user()->id);
            $hasVeiculos = (count($request->veiculos) > 0);
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
                'apartamento_id' => $request->apartamento
            ]);


            foreach ($request->veiculos as $veiculo) {
                LocatarioVeiculoRepository::create($veiculo, $locatario);
            }

            foreach ($request->convidados as $convidado) {
                LocatarioConvidadoRepository::create($convidado, $locatario);
            }

            return 'ok';
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function updateLocatario($request, $id)
    {
        try {

            $locatario = Locatario::with(['convidados', 'veiculos'])->findOrFail($id);

            LocatarioVeiculoRepository::update($request, $locatario);
            LocatarioConvidadoRepository::update($request, $locatario);

            $hasVeiculos = (count($request->veiculos) > 0);
            $hasConvidados = (count($request->convidados) > 0);

            $locatario->nome = $request->nomeLocatario;
            $locatario->cpf = clearCpf($request->cpf);
            $locatario->data_chegada = $request->dataChegada;
            $locatario->data_saida = $request->dataSaida;
            $locatario->celular = $request->celular;
            $locatario->email = $request->email;
            $locatario->observacoes = $request->observacoes;
            $locatario->possui_veiculos = $hasVeiculos;
            $locatario->possui_convidados = $hasConvidados;
            $locatario->apartamento_id = $request->apartamento;

            $locatario->save();


            return 'ok';
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }


    public static function destroyLocatario($request, $id)
    {
        try {
            $user = auth()->user();
            Locatario::where('user_id', $user->id)->findOrFail($id)->delete();
            return 'ok';
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}
