<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocatarioRequest;
use App\Models\Locatario;
use App\Models\LocatarioConvidado;
use App\Models\LocatarioVeiculo;
use App\Repositories\LocatarioRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class LocatarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Locatario::with(['apartamento'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLocatarioRequest $request)
    {
        // return $request->all();
        $created = LocatarioRepository::createLocatario($request);
        return response($created, ($created == 'ok')? 201 : 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Locatario::with(['veiculos', 'convidados', 'apartamento.proprietarios.user'])->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateLocatarioRequest $request, $id)
    {
        $updated = LocatarioRepository::updateLocatario($request, $id);
        return response($updated, (!isset($updated['error']))? 200 : 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $deleted = LocatarioRepository::destroyLocatario($request, $id);
        return response($deleted, (!isset($deleted['error']))? 200 : 400);
        
    }
}
