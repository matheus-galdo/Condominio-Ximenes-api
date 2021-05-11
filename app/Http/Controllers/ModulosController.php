<?php

namespace App\Http\Controllers;

use App\Models\Sistema\Modulo;
use App\Models\Sistema\Modulos;
use Illuminate\Http\Request;

class ModulosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Modulos::where('nome', '!=', 'modulos')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response('', 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sistema\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function show(Modulos $modulo)
    {
        return response()->json($modulo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sistema\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modulos $modulo)
    {
        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sistema\Modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modulos $modulo)
    {
        return response('', 204);
    }
}
