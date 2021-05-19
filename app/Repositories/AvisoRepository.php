<?php

namespace App\Repositories;

use App\Models\Aviso;

class AvisoRepository
{

    public static function create($request)
    {
        try {
            $user = auth()->user();

            if (!$user->typeName->is_admin) throw new \Exception("User not allowed", 1);

            Aviso::create([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'data_expiracao' => $request->dataExpiracao,
                'user_id' => $user->id
            ]);

            return ['status' => true, 'code' => 201];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }


    public static function update($request, $id)
    {
        try {
            $user = auth()->user();
            $aviso = Aviso::withTrashed()->findOrFail($id);

            if (!$user->typeName->is_admin) throw new \Exception("User not allowed", 1);

            if (isset($request->ativar)) {
                if ($aviso->ativar) {
                    $aviso->restore();
                } else {
                    $aviso->delete();
                }
            } else {
                $aviso->titulo = $request->titulo;
                $aviso->descricao = $request->descricao;
                $aviso->data_expiracao = $request->dataExpiracao;
                $aviso->save();
            }

            return ['status' => true, 'code' => 201];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function delete($aviso)
    {
        try {
            $aviso = Aviso::withTrashed()->findOrFail($aviso);
            if ($aviso->trashed()) {
                $aviso->forceDelete();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}
