<?php

namespace App\Repositories;

use App\Models\LocatarioConvidado;

class LocatarioConvidadoRepository
{
    
    /**
     * create
     *
     * @param  mixed $convidado
     * @param  mixed $locatario
     * @return void
     */
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

    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $locatario
     * @return void
     */
    public static function update($request, $locatario)
    {
        $savedConvidados = $locatario->convidados->keyBy('id');
        
        foreach ($request->convidados as $convidado) {

            if (isset($convidado['id'])) {
                $convidadoId = $convidado['id']['value'];

                $findedConvidado = $savedConvidados[$convidadoId];                    
                $findedConvidado->nome = $convidado['nomeConvidado']['value'];
                $findedConvidado->cpf = $convidado['cpf']['value'];
                $findedConvidado->celular = $convidado['celular']['value'];
                $findedConvidado->email = $convidado['email']['value'];
                $findedConvidado->observacoes = $convidado['observacoes']['value'];

                $findedConvidado->save();
                $savedConvidados->forget($convidadoId);
            
            }else{
                self::create($convidado, $locatario);
            }
        }

        foreach ($savedConvidados as $convidado) {
            $convidado->delete();
        }
    }
}
