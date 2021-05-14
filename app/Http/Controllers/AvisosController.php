<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Repositories\AvisoRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Aviso::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return AvisoRepository::create($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aviso  $aviso
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Aviso $aviso)
    {
        return $aviso;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aviso  $aviso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aviso $aviso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aviso  $aviso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Aviso $aviso)
    {
        return $aviso->delete();
    }
}
