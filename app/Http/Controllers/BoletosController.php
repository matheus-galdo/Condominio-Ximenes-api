<?php

namespace App\Http\Controllers;

use App\Http\Requests\Boletos\CreateBoletoRequest;
use App\Http\Requests\Boletos\UpdateBoletoRequest;
use App\Http\Resources\Boletos\BoletoResource;
use App\Http\Resources\Boletos\BoletoWithAuthorResource;
use App\Models\Boleto;
use App\Models\Proprietario;
use App\Repositories\BoletoRepository;
use App\Services\PdfToStringService;
use App\Services\ReaderBoletoInterService;
use App\Services\SearchAndFilter\SearchAndFilter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BoletosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = (new Boleto)->newQuery()->with('apartamento');

        if (auth()->user()->typeName->is_admin) {
            $builder = $builder->withTrashed();
        }

        if (!empty($request->search)) {
            preg_match_all("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/m",$request->search, $matches, PREG_SET_ORDER, 0);
            $date = (isset($matches[0]))? Carbon::createFromFormat('d/m/Y', $request->search)->format('Y-m-d'):'';

            $builder = $builder->where('nome', 'LIKE', "%{$request->search}%")
                ->orWhere('vencimento', $date)
                ->orWhereHas('apartamento', function($builder) use($request){
                    return $builder->where('apartamentos.numero', $request->search);
                });
        }

        if (!empty($request->filter)) {

            $filter = new SearchAndFilter(new Boleto);
            $filter->setCustomRule('valor', ['boletos.valor', 'DESC'], 'orderBy');
            $builder = $filter->getBuilderWithFilter($request->filter, $builder);
        }


        if (!auth()->user()->typeName->is_admin) {
            $proprietarioApartamentosIds = auth()->user()->proprietario->apartamentos->pluck('id')->toArray();
            $builder = $builder->whereHas('apartamento', function ($builder) use ($request, $proprietarioApartamentosIds) {
                return $builder->whereIn('id', $proprietarioApartamentosIds);
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
    public function store(CreateBoletoRequest $request)
    {
        $response = BoletoRepository::create($request);
        return response($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Boleto  $boleto
     * @return \Illuminate\Http\Response
     */
    public function show($boletoId)
    {
        $boleto = Boleto::withoutTrashed()->with('cadastradoPor')->findOrFail($boletoId);
        if (auth()->user()->typeName->is_admin) {
            return response(new BoletoWithAuthorResource($boleto));
        }

        $proprietarioApartamentosIds = auth()->user()->proprietario->apartamentos->pluck('id')->toArray();
        if (in_array($boleto->apartamento_id, $proprietarioApartamentosIds)) {
            return response(new BoletoResource($boleto));
        }

        return response()->json('não autorizado', 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Boleto  $boleto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBoletoRequest $request, $boletoId)
    {
        $response = BoletoRepository::update($request, $boletoId);
        return response($response, $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Boleto  $boleto
     * @return \Illuminate\Http\Response
     */
    public function destroy($boletoId)
    {
        $response = BoletoRepository::delete($boletoId);
        return response($response, $response['code']);
    }
}
