<?php

namespace App\Http\Controllers;

use App\Models\Ocorrencia;
use App\Models\OcorrenciaFollowup;
use Illuminate\Http\Request;

class OcorrenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ocorrencia::with(['user'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $ocorrencia = Ocorrencia::create([
                'assunto' => $request->assunto,
                'descricao' => $request->descricao,
                'user_id' => auth()->user()->id,
            ]);

            OcorrenciaFollowup::create([
                'descricao' => 'Ocorrência criada',
                'evento_followup_id' => 1,
                'ocorrencia_id' => $ocorrencia->id
            ]);



            return response(true, 200);

        } catch (\Throwable $th) {
            throw $th;
            return response(['error'=> $th], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Ocorrencia::with(['followup'])->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
