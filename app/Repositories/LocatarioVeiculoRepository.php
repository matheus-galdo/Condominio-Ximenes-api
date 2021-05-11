<?php

namespace App\Repositories;

use App\Models\LocatarioVeiculo;

class LocatarioVeiculoRepository
{
    
    /**
     * create
     *
     * @param  mixed $veiculo
     * @param  mixed $locatario
     * @return void
     */
    public static function create($veiculo, $locatario)
    {
        LocatarioVeiculo::create([
            'placa' => $veiculo['placa']['value'],
            'modelo' => $veiculo['modelo']['value'],
            'cor' => $veiculo['cor']['value'],
            'locatario_id' => $locatario->id
        ]);
    }


        
    /**
     * update
     *
     * @param  mixed $savedVeiculos
     * @param  mixed $request
     * @param  mixed $locatario
     * @return void
     */
    public static function update($request, $locatario)
    {
        $savedVeiculos = $locatario->veiculos->keyBy('id');
        
        foreach ($request->veiculos as $veiculo) {

            if (isset($veiculo['id'])) {
                $veiculoId = $veiculo['id']['value'];

                $findedVeiculo = $savedVeiculos[$veiculoId];                    
                $findedVeiculo->placa = $veiculo['placa']['value'];
                $findedVeiculo->modelo = $veiculo['modelo']['value'];
                $findedVeiculo->cor = $veiculo['cor']['value'];
                $findedVeiculo->save();
                $savedVeiculos->forget($veiculoId);
            
            }else{
                self::create($veiculo, $locatario);
            }
        }

        foreach ($savedVeiculos as $veiculo) {
            $veiculo->delete();
        }
    }
}
