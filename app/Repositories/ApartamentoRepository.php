<?php

namespace App\Repositories;

use App\Http\Resources\Apartamentos\ApartamentoProprietarioResource;
use App\Models\Apartamento;

class ApartamentoRepository
{

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
                'bloco' => $request->bloco,
                'numero' => $request->numero,
                'andar' => $request->andar
            ]);

            return ['status' => true, 'code' => 201];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function show($id)
    {

        try {
            $apartamento = new ApartamentoProprietarioResource(Apartamento::with(['proprietarios.user.typeName'])->findOrFail($id));
            // $apartamento = Apartamento::with(['proprietarios.user.typeName'])->findOrFail($id);

            // $apartamento = $apartamento->toArray();
            // $apartamento['code'] = 201;
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
    public static function update($request, $id)
    {
        try {
            $apartamento = Apartamento::withTrashed()->findOrFail($id);

            if (isset($request->ativar)) {
                ($request->ativar) ? $apartamento->restore() : $apartamento->delete();
            } else {
                $apartamento->bloco = $request->bloco;
                $apartamento->numero = $request->numero;
                $apartamento->andar = $request->andar;
                $apartamento->save();
            }

            return ['status' => true, 'code' => 201];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function delete($id)
    {
        try {
            $apartamento = Apartamento::withTrashed()->find($id);
            if ($apartamento->trashed()) {
                $apartamento->forceDelete();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}
