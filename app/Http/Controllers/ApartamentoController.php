<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApartamentoRequest;
use App\Models\Apartamento;
use App\Repositories\ApartamentoRepository;

class ApartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Apartamento::with(['proprietarios'])->withTrashed()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApartamentoRequest $request)
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
        $response = ApartamentoRepository::show($apartamentoId);
        return response($response, $response['code']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartamento  $apartamento
     * @return \Illuminate\Http\Response
     */
    public function update(ApartamentoRequest $request, Apartamento $apartamento)
    {
        $response = ApartamentoRepository::update($request, $apartamento);
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
