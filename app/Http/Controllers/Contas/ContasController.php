<?php

namespace App\Http\Controllers\Contas;

use App\Http\Controllers\Controller;
use App\Models\PrestacaoContas\ArquivoConta;
use App\Repositories\ContasRepository;
use App\Repositories\PrestacaoContasRepository;
use App\Services\SearchAndFilter\SearchAndFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    private const MONTHS_PTBR = [
        1 => 'janeiro',
        2 => 'fevereiro',
        3 => 'março',
        4 => 'abril',
        5 => 'maio',
        6 => 'junho',
        7 => 'julho',
        8 => 'agosto',
        9 => 'setembro',
        10 => 'outubro',
        11 => 'novembro',
        12 => 'dezembro',
    ];

    public function index(Request $request)
    {
        DB::enableQueryLog();
        $filter = (isset($request->filter)) ? $request->filter : 'nome';

        $builder = new ArquivoConta();
        $builder = $builder->newQuery();

        if (auth()->user()->typeName->is_admin) {
            $builder = $builder->withTrashed();
        }

        if (!empty($request->search)) {

            $lowerCaseSearchTerms = strtolower($request->search);
            foreach (self::MONTHS_PTBR as $monthNumber => $month) {
                if (strpos($lowerCaseSearchTerms, $month) !== false) {

                    $builder = $builder->where(DB::raw("month(periodo)"), $monthNumber);
                }
            }
            $builder = $builder->orWhere('nome', 'LIKE', "%{$request->search}%");
        }

        if (!empty($request->filter)) {
            $filter = new SearchAndFilter(new ArquivoConta);
            $filter->setCustomRule('periodo', ['periodo','ASC'], 'orderBy');
            $builder = $filter->getBuilderWithFilter($request->filter, $builder);
        }
                
        if ($request->page) return response()->json($builder->paginate(15));
        return response()->json($builder->get()); 
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
