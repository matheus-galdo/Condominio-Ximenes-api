<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocatarioRequest;
use App\Models\Locatario;
use App\Models\LocatarioConvidado;
use App\Models\LocatarioVeiculo;
use App\Repositories\LocatarioRepository;
use App\Services\SearchAndFilter\SearchAndFilter;
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
    public function index(Request $request)
    {
        $builder = (new Locatario)->newQuery()->with(['apartamento']);


        if (auth()->user()->typeName->is_admin) {
            // $builder = $builder->withTrashed();
            // $builder = $builder->withTrashed();
        }

        if (!empty($request->search)) {
            $builder = $builder->where('nome', 'LIKE', "%{$request->search}%")
            ->orWhere('apartamentos.numero','LIKE', "%{$request->search}%");
        }

        $filter = new SearchAndFilter(new Locatario);
        // $filter->setCustomRule('numero_ap', ['apartamentos.numero', 'DESC'], 'orderBy');
        if (!empty($request->filter)) {
            $builder = $filter->getBuilderWithFilter($request->filter, $builder);

            if ($request->filter) {
                $builder = $builder->whereHas('apartamento', function($builder) use($request){
                    return $builder->orderBy('apartamentos.numero', 'DESC');
                });
            }
        }

        if ($request->page) {
            return response($builder->paginate(15));
        }

        return $builder->get();
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
        $response = LocatarioRepository::createLocatario($request);
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
