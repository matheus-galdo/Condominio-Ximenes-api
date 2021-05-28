<?php

namespace App\Http\Controllers;

use App\Http\Requests\Apartamentos\CreateApartamentoRequest;
use App\Http\Requests\Apartamentos\UpdateApartamentoRequest;
use App\Http\Resources\Apartamentos\ApartamentoProprietarioResource;
use App\Models\Apartamento;
use App\Repositories\ApartamentoRepository;
use App\Services\SearchAndFilter\SearchAndFilter;
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
        $apartamento = new Apartamento;
        $apartamentosBuilder = $apartamento->newQuery();
        
        if (auth()->user()->typeName->is_admin) {
            $apartamentosBuilder = $apartamentosBuilder->withTrashed();
        }

        if (!auth()->user()->typeName->is_admin) {
            $apartamentosBuilder = $apartamentosBuilder->has('proprietarios')->whereHas('proprietarios', function ($builder)
            {
                $builder->where('proprietario_id', auth()->user()->proprietario->id);
            });
        }

        if (!empty($request->search)) {
            $apartamentosBuilder = $apartamentosBuilder->where('numero', 'LIKE', "%{$request->search}%");
        }

        if(isset($request->proprietarios) && $request->proprietarios) $apartamentosBuilder->with(['proprietarios.user']);

        $filter = new SearchAndFilter(new Apartamento);
        
        if ($request->page) {
            $apartamentosBuilder = $filter->getBuilderWithFilter($request->filter);
            return response($apartamentosBuilder->paginate(15));
        }
        return response($apartamentosBuilder->get());
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
        $response = ApartamentoRepository::delete($apartamentoId);
        return response($response, $response['code']);
    }
}
