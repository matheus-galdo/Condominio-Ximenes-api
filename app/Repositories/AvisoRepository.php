<?php

namespace App\Repositories;

use App\Models\Aviso;

class AvisoRepository{

    public static function create($request)
    {
        try {
            $user = auth()->user();
           
            Aviso::create([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'data_expiracao' => $request->dataExpiracao,
                'user_id' => $user->id
            ]);

            return true;
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}