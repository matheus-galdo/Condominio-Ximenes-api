<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Documentos\CreateDocumentoRequest;
use App\Http\Requests\Documentos\UpdateDocumentoRequest;
use App\Http\Resources\DocumentoResource;
use App\Models\Documento;
use App\Repositories\DocumentoRepository;
use App\Services\SearchAndFilter\SearchAndFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = (new Documento)->newQuery();

        if (auth()->user()->typeName->is_admin) {
            $builder = $builder->withTrashed();
        }

        if (!empty($request->search)) {
            $builder = $builder->where('nome', 'LIKE', "%{$request->search}%");
        }

        if (!empty($request->filter)) {
            $filter = new SearchAndFilter(new Documento);
            $builder = $filter->getBuilderWithFilter($request->filter, $builder);
        }


        if (!auth()->user()->typeName->is_admin) {
            $builder = $builder->where('is_public', true)->where(function($builder){
                $builder->where('documentos.data_expiracao', null);
                $builder->orWhere('documentos.data_expiracao', '>=', now());
            });
        }

        if (isset($request->page) && $request->page) return response($builder->paginate(15));
        return $builder->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDocumentoRequest $request)
    {
        $response = DocumentoRepository::create($request);
        return response($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function show($documentoId)
    {
        $documento = Documento::withTrashed()->findOrFail($documentoId);
        $documento->setAttribute('size', Storage::size($documento->path));
        return $documento;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocumentoRequest $request, $documentoId)
    {
        $response = DocumentoRepository::update($request, $documentoId);
        return response($response, $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy($documentoId)
    {
        $documento = Documento::withTrashed()->findOrFail($documentoId);
        $response = DocumentoRepository::delete($documento);
        return response($response, $response['code']);
    }
}
