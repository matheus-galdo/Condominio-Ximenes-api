<?php

namespace App\Http\Controllers\Contas;

use App\Http\Controllers\Controller;
use App\Models\PrestacaoContas\ArquivoConta;
use App\Repositories\ContasRepository;
use App\Repositories\PrestacaoContasRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Type\TypeName;
use Smalot\PdfParser\Parser;

class ContasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $builder = new ArquivoConta();
        $builder = $builder->newQuery();

        if (auth()->user()->typeName->is_admin) {
            $builder->withTrashed();
        }

        return $builder->get();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = PrestacaoContasRepository::create($request);
        return response($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($contaId)
    {
        $conta = ArquivoConta::withTrashed()->findOrFail($contaId);
        $conta->setAttribute('size', Storage::size($conta->path));
        return $conta;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contaId)
    {
        $response = PrestacaoContasRepository::update($request, $contaId);
        return response($response, $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($contaId)
    {
        $documento = ArquivoConta::withTrashed()->findOrFail($contaId);
        $response = PrestacaoContasRepository::delete($documento);
        return response($response, $response['code']);
    }
}
