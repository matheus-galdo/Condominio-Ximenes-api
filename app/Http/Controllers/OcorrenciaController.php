<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ocorrencias\CreateOcorrenciaRequest;
use App\Http\Requests\Ocorrencias\UpdateOcorrenciaRequest;
use App\Models\Ocorrencia\EventoFollowupAnexos;
use App\Models\Ocorrencia\Ocorrencia;
use App\Models\Ocorrencia\OcorrenciaFollowup;
use App\Models\User;
use App\Repositories\OcorrenciaRepository;
use App\Services\SearchAndFilter\SearchAndFilter;
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
    public function index(Request $request)
    {

        $builder = (new Ocorrencia)->newQuery()->with(['apartamento', 'followup.evento']);

        if (auth()->user()->typeName->is_admin) {
            $builder = $builder->withTrashed();
        }

        if (!auth()->user()->typeName->is_admin) {
            $proprietarioApartamentosIds = auth()->user()->proprietario->apartamentos->pluck('id')->toArray();
            $builder = $builder->whereHas('apartamento', function ($builder) use ($proprietarioApartamentosIds) {
                return $builder->whereIn('id', $proprietarioApartamentosIds);
            });
        }

        if (!empty($request->search)) {
            $builder = $builder->where('assunto', 'LIKE', "%{$request->search}%");
        }


        
        
        if (!empty($request->filter)) {
            $filter = new SearchAndFilter(new Ocorrencia);
            $filter->setCustomRule('assunto', ['ocorrencias.assunto', 'ASC'], 'orderBy');
            $builder = $filter->getBuilderWithFilter($request->filter, $builder);
            
            if ($request->filter == 'concluidas') {
                $builder = $builder->whereHas('followup.evento', function ($builder){
                    return $builder->where('evento_followup.nome', 'Concluída');
                });
            }

            if ($request->filter == 'canceladas') {
                $builder = $builder->whereHas('followup.evento', function ($builder){
                    return $builder->where('evento_followup.nome', 'Cancelada');
                });
            }         
        }

        if ($request->page) return response($builder->paginate(15));
        return $builder->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOcorrenciaRequest $request)
    {
        // exists:App\Models\Ocorrencia\Ocorrencia,id

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
    public function update(UpdateOcorrenciaRequest $request, $id)
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
