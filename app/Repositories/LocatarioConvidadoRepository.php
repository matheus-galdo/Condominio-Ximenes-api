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
            'nome' => $convidado['nomeConvidado'],
            'cpf' => clearCpf($convidado['cpf']),
            'celular' => $convidado['celular'],
            'crianca' => (bool) $convidado['crianca'],
            'observacoes' => $convidado['observacoes'],
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
                $convidadoId = $convidado['id'];

                $findedConvidado = $savedConvidados[$convidadoId];                    
                $findedConvidado->nome = $convidado['nomeConvidado'];
                $findedConvidado->cpf = $convidado['cpf'];
                $findedConvidado->celular = $convidado['celular'];
                $findedConvidado->email = $convidado['email'];
                $findedConvidado->observacoes = $convidado['observacoes'];

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
