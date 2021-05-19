<?php

namespace App\Http\Controllers;

use App\Models\Ocorrencia\OcorrenciaFollowup;
use App\Repositories\OcorrenciaFollowupRepository;
use Illuminate\Http\Request;

class OcorrenciaFollowupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($followupId)
    {
        if (auth()->user()->typeName->is_admin) {
            return response()->json(OcorrenciaFollowup::withTrashed()->with(['anexos'])->findOrFail($followupId));
        }
        return response()->json(['status' => false, 'error' => 'Você não pode acessar este recurso'], 403);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = OcorrenciaFollowupRepository::create($request);
        return response($response, $response['code']);        
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
        $response = OcorrenciaFollowupRepository::update($request, $id);
        return response($response, $response['code']); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $followup = OcorrenciaFollowup::withTrashed()->find($id);
        $response = OcorrenciaFollowupRepository::delete($followup);
        return response($response, $response['code']); 
    }
}
