<?php

namespace App\Repositories;

use App\Models\Documento;
use App\Models\Ocorrencia\EventoFollowup;
use App\Models\Ocorrencia\EventoFollowupAnexos;
use App\Models\Ocorrencia\Ocorrencia;
use App\Models\Ocorrencia\OcorrenciaFollowup;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OcorrenciaRepository
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
            $user = User::find(auth()->user()->id);

            if (!$user->typeName->is_admin) {
                $aps = $user->proprietario->apartamentos->firstWhere('id', $request->apartamento);
                if (empty($aps)) throw new \Exception("Recursos solicidado não permitido", 1);
            }


            DB::transaction(function () use ($user, $request) {

                $ocorrencia = Ocorrencia::create([
                    'assunto' => $request->assunto,
                    'apartamento_id' => $request->apartamento,
                    'autor_id' => $user->id
                ]);

                $request->evento = 1;
                $request->ocorrencia = $ocorrencia->id;

                $r = OcorrenciaFollowupRepository::create($request);

                if (isset($r['error'])) {
                    throw new \Exception($r['exception'] ? $r['exception'] : 'Internal repository error', 1);
                }
            });

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
            $ocorrencia = Ocorrencia::withTrashed()->findOrFail($id);

            if (isset($request->ativar)) {
                if ($request->ativar) {
                    $ocorrencia->restore();
                } else {
                    $ocorrencia->delete();
                }
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function delete($ocorrencia)
    {
        try {
            if ($ocorrencia->trashed()) {
                $ocorrencia->forceDelete();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}
