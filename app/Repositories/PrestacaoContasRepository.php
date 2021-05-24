<?php

namespace App\Repositories;

use App\Models\Documento;
use App\Models\PrestacaoContas\ArquivoConta;
use Illuminate\Support\Facades\Storage;

class PrestacaoContasRepository
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
                $filePath = $file->store('pretacao_contas/documents');

                $contas = ArquivoConta::create([
                    'nome' => $file->getClientOriginalName(),
                    'periodo' => $request->periodo,
                    
                    'extensao' => $file->extension(),
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
            $contas = ArquivoConta::withTrashed()->findOrFail($id);

            if (isset($request->ativar)) {
                if ($request->ativar) {
                    $contas->restore();
                } else {
                    $contas->delete();
                }
            } else {
                $contas->nome = $request->periodo;
                $contas->save();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function delete($contas)
    {
        try {
            if ($contas->trashed()) {
                $contas->forceDelete();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}
