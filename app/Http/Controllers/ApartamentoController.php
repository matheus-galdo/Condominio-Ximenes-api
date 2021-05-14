<?php

namespace App\Http\Controllers;

use App\Http\Requests\Apartamentos\CreateApartamentoRequest;
use App\Http\Requests\Apartamentos\UpdateApartamentoRequest;
use App\Http\Resources\Apartamentos\ApartamentoProprietarioResource;
use App\Models\Apartamento;
use App\Repositories\ApartamentoRepository;
use Illuminate\Http\Request;

class ApartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $apartamentosBuilder = Apartamento::withTrashed();
        if(isset($request->proprietarios) && $request->proprietarios) $apartamentosBuilder->with(['proprietarios.user']);
        
        return response($apartamentosBuilder->orderBy('deleted_at')->orderBy('numero')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateApartamentoRequest $request)
    {
        $response = ApartamentoRepository::create($request);
        return response($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartamento  $apartamento
     * @return \Illuminate\Http\Response
     */
    public function show($apartamentoId)
    {   
        $apartamento = Apartamento::withTrashed()->with(['proprietarios.user.typeName'])->findOrFail($apartamentoId);
        $apartamento = new ApartamentoProprietarioResource($apartamento);
        return response($apartamento, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartamento  $apartamento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartamentoRequest $request, $apartamentoId)
    {
        $response = ApartamentoRepository::update($request, $apartamentoId);
        return response($response, $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartamento  $apartamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($apartamentoId)
    {
        $apartamento = Apartamento::withTrashed()->find($apartamentoId);
        $response = ApartamentoRepository::delete($apartamento);
        return response($response, $response['code']);
    }
}
