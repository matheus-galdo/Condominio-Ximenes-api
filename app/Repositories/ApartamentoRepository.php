<?php

namespace App\Repositories;

use App\Models\Apartamento;

class ApartamentoRepository{
    
    /**
     * create
     *
     * @param  mixed $request
     * @return void
     */
    public static function create($request)
    {
        try {
           
            Apartamento::create([
                'bloco' => $request->titulo,
                'numero' => $request->descricao,
                'andar' => $request->dataExpiracao,
                'ativo' => $request->ativo,
            ]);

            return ['status' => true, 'code' => 201];
        } catch (\Throwable $th) {
            return ['error' => $th, 'code' => 400];
        }
    }

    public static function show($id)
    {
        
        try {
            $apartamento = Apartamento::with(['proprietarios'])->findOrFail($id)->toArray();
            $apartamento['code'] = 201;
            return $apartamento;
        } catch (\Throwable $th) {
            return ['error' => $th, 'code' => 400];
        }
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $apartamento
     * @return void
     */
    public static function update($request, $apartamento)
    {        
        try {
            $apartamento->a = $request->titulo;
            $apartamento->a = $request->descricao;
            $apartamento->a = $request->dataExpiracao;
            $apartamento->a = $request->ativo;

            $apartamento->save();

            return ['status' => true, 'code' => 201];
        } catch (\Throwable $th) {
            return ['error' => $th, 'code' => 400];
        }
    }

    public static function delete($apartamento)
    {
        try {
            $a = null;
            if ($apartamento->trashed()) {
                $apartamento->forceDelete();
            }else{
                $apartamento->delete();
            }

            return ['status' => true, 'code' => 200];

        } catch (\Throwable $th) {
            //throw $th;
            return ['error' => $th, 'code' => 400];
        }
    }
}