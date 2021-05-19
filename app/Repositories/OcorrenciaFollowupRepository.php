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
        try {
            try {
                $fileAnexo = collect();
                DB::transaction(function () use ($request, $fileAnexo) {

                    $followup = OcorrenciaFollowup::create([
                        'descricao' => $request->descricao,
                        'evento_followup_id' => $request->evento,
                        'ocorrencia_id' => $request->ocorrencia
                    ]);

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
            $followup = OcorrenciaFollowup::withTrashed()->findOrFail($id);

            if (isset($request->ativar)) {
                if ($request->ativar) {
                    $followup->restore();
                } else {
                    $followup->delete();
                }
            } else {
                $followup->nome = $request->nome_arquivo;
                $followup->is_public = $request->publico;
                $followup->data_expiracao = $request->data_expiracao;
                $followup->save();
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
