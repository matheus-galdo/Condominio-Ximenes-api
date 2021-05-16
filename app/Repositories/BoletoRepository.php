<?php

namespace App\Repositories;

use App\Models\Apartamento;
use App\Models\ApartamentosProprietario;
use App\Models\Boleto;
use App\Models\Documento;
use App\Models\Proprietario;
use App\Models\Sistema\UserType;
use App\Models\User;
use App\Services\ReaderBoletoInterService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BoletoRepository
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
            try {
                $file = $request->arquivos[0];
                $filePath = $file->store('userFiles/boletos');

                list($vencimento, $valor, $codigoDeBarras) = ReaderBoletoInterService::parseFile(storage_path('app/' . $filePath));

                $boleto = Boleto::create([
                    'nome' => $request->despesa,
                    'valor' => $valor,
                    'codigo_barras' => $codigoDeBarras,
                    'vencimento' => $vencimento,
                    'pago' => false,

                    'apartamento_id' => $request->apartamento,
                    'cadastrado_por_user_id' => auth()->user()->id,
                    'path' => $filePath,

                ]);
            } catch (\Throwable $th) {
                Storage::delete($filePath);
                throw $th;
            }

            return ['status' => true, 'code' => 201];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
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
            $boleto = Boleto::withTrashed()->findOrFail($id);

            if (isset($request->ativar)) {
                if ($boleto->ativar) {
                    $boleto->restore();
                    $boleto->typeName()->restore();
                } else {
                    $boleto->delete();
                }
            } else if (isset($request->pagar)) {

                $boleto->pago = (bool) $request->pagar;

                if ($request->pagar) {
                    $boleto->data_pagamento = Carbon::now();
                } else {
                    $boleto->data_pagamento = null;
                }
                $boleto->save();
            } else {
                $boleto->nome = $request->despesa;
                $boleto->apartamento_id = $request->apartamento;
                $boleto->save();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function delete($boleto)
    {
        try {
            if ($boleto->trashed()) {
                $boleto->forceDelete();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}
