<?php

namespace App\Http\Controllers;

use App\Models\Ocorrencia\EventoFollowupAnexos;
use App\Models\Ocorrencia\Ocorrencia;
use App\Models\Ocorrencia\OcorrenciaFollowup;
use App\Models\User;
use App\Repositories\OcorrenciaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OcorrenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ocorrenciasBuilder = Ocorrencia::with(['apartamento', 'followup.evento']);
        if (auth()->user()->typeName->is_admin) {
            return response($ocorrenciasBuilder->withTrashed()->get());
        }

        $proprietarioApartamentosIds = auth()->user()->proprietario->apartamentos->pluck('id')->toArray();
        $ocorrenciasBuilder = $ocorrenciasBuilder->whereHas('apartamento', function ($builder) use ($proprietarioApartamentosIds) {
            return $builder->whereIn('id', $proprietarioApartamentosIds);
        });

        return response($ocorrenciasBuilder->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = OcorrenciaRepository::create($request);
        return response($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $builder = Ocorrencia::with(['apartamento', 'autor.typeName']);

        if (auth()->user()->typeName->is_admin) {
            $ocorrencia = $builder->withTrashed()->with([
                'followup' => function ($innerBuilder) {
                    $innerBuilder->withTrashed()->with(['anexos', 'evento']);
                }
            ])->findOrFail($id);
            return response()->json($ocorrencia);
        }

        return $builder->with(['followup.anexos', 'followup.evento'])->findOrFail($id);
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
        $response = OcorrenciaRepository::update($request, $id);
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
        $ocorrencia = Ocorrencia::withTrashed()->find($id);
        $response = OcorrenciaRepository::delete($ocorrencia);
        return response($response, $response['code']); 
    }
}
