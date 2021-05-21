<?php

namespace App\Repositories;

use App\Models\Documento;
use App\Models\Ocorrencia\EventoFollowupAnexos;
use App\Models\Ocorrencia\Ocorrencia;
use App\Models\Ocorrencia\OcorrenciaFollowup;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OcorrenciaFollowupRepository
{

    /**
     * create
     *
     * @param  mixed $request
     * @return void
     */
    public static function create($request)
    {
        $followup_final = ['Concluída', 'Cancelada'];

        try {
            try {
                $fileAnexo = collect();

                $a = DB::transaction(function () use ($request, $fileAnexo, $followup_final) {

                    $ocorrencia = Ocorrencia::withTrashed()->findOrFail($request->ocorrencia);
                    $lastFollowup = $ocorrencia->followup->last();
                    
                    $followup = OcorrenciaFollowup::create([
                        'descricao' => $request->descricao,
                        'evento_followup_id' => $request->evento,
                        'ocorrencia_id' => $request->ocorrencia
                    ]);

                    if (!empty($lastFollowup)) {
                        if (in_array($lastFollowup->evento->nome, $followup_final) && $followup->evento->nome != 'Reaberta') {
                            $followup->delete();
                            throw new \Exception("Esta ocorrência foi encerrada e não pode receber este followup", 1);
                        }
                    }

                    if (isset($request->arquivos)) {
                        foreach ($request->arquivos as $file) {
                            $filePath = $file->store('userFiles/ocorrencias');

                            $anexo = EventoFollowupAnexos::create([
                                'nome_original' => $file->getClientOriginalName(),
                                'extensao' => $file->extension(),
                                'path' => $filePath,
                                'ocorrencia_followup_id' => $followup->id
                            ]);

                            $fileAnexo->push($anexo);
                        }
                    }
                });
            } catch (\Throwable $th) {
                foreach ($fileAnexo as $filePath) {
                    Storage::delete($filePath);
                }
                throw $th;
            }

            return ['status' => true, 'a' => $a, 'code' => 201];
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
            $followup = OcorrenciaFollowup::withTrashed()->findOrFail($id);

            if (isset($request->ativar)) {
                if ($request->ativar) {
                    $followup->restore();
                } else {
                    $followup->delete();
                }
            } else {

                $followup->update([
                    'descricao' => $request->descricao,
                    'ocorrencia_id' => $request->ocorrencia
                ]);
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function delete($followup)
    {
        try {
            if ($followup->trashed()) {
                $followup->forceDelete();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}
