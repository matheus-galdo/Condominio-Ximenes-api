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

        $avisosBuilder = (new Aviso)->newQuery();

        if (auth()->user()->typeName->is_admin) {
            $avisosBuilder->withTrashed();
            return response($avisosBuilder->orderBy('deleted_at')->orderBy('titulo')->get());
        }

        return $avisosBuilder->where('data_expiracao', '>=', Carbon::now())->orWhereNull('data_expiracao')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = AvisoRepository::create($request);
        return response($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aviso  $aviso
     * @return \Illuminate\Http\Response
     */
    public function show($avisoId)
    {
        if (auth()->user()->typeName->is_admin) return Aviso::withTrashed()->with('autor')->findOrFail($avisoId);
        return Aviso::findOrFail($avisoId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aviso  $aviso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $avisoId)
    {
        $response = AvisoRepository::update($request, $avisoId);
        return response($response, $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aviso  $aviso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $avisoId)
    {
        $response = AvisoRepository::delete($avisoId);
        return response($response, $response['code']);
    }
}
