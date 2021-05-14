<?php

namespace App\Repositories;

use App\Models\Apartamento;
use App\Models\ApartamentosProprietario;
use App\Models\Documento;
use App\Models\Proprietario;
use App\Models\Sistema\UserType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentoRepository
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
            foreach ($request->arquivos as $file) {

                $filePath = $file->store('userFiles/documents');
                
                
                try {
                    $documento = Documento::create([
                        'nome' => $request->nome_arquivo,
                        'data_expiracao' => $request->data_expiracao,
                        'is_public' => (boolean) $request->publico,

                        'nome_original' => $file->getClientOriginalName(),
                        'extensao' => $file->extension(),
                        'path' => $filePath,
                    ]);
                } catch (\Throwable $th) {
                    Storage::delete($filePath);
                    throw $th;                    
                }
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
            $documento = Documento::withTrashed()->findOrFail($id);

            if (isset($request->ativar)) {
                if ($request->ativar) {
                    $documento->restore();
                    $documento->typeName()->restore();
                } else {
                    $documento->delete();
                }
            
            } else {
                $documento->nome = $request->nome_arquivo;
                $documento->is_public = $request->publico;
                $documento->data_expiracao = $request->data_expiracao;
                $documento->save();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function delete($documento)
    {
        try {
            if ($documento->trashed()) {
                $documento->forceDelete();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}
