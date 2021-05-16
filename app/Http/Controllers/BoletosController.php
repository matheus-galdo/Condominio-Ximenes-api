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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoletosController extends Controller
{
    //     ativar
    // pagar
    // despesa
    // apartamento

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boletosBuilder = Boleto::orderBy('vencimento')->with('apartamento');
        if (auth()->user()->typeName->is_admin) {
            return response(BoletoResource::collection($boletosBuilder->withTrashed()->get()));
        }

        // $user = auth()->user();
        // $proprietario = Proprietario::where('user_id', $user->id)->with('apartamentos.boletos')->firstOrFail();
        // $boletos = collect();
        // foreach($proprietario->apartamentos as $apartamento){
        //     foreach($apartamento->boletos as $boleto){
        //         $boletos->push($boleto);
        //     };
        // };
        // return response($boletos);
        // return response(BoletoResource::collection(auth()->user()->proprietario->apartamentos->boletos));

        $proprietarioApartamentosIds = auth()->user()->proprietario->apartamentos->pluck('id')->toArray();

        $boletosBuilder = $boletosBuilder->whereHas('apartamento', function ($builder) use ($proprietarioApartamentosIds) {
            return $builder->whereIn('id', $proprietarioApartamentosIds);
        });
        return response(BoletoResource::collection($boletosBuilder->get()));
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
            // return response($boleto);
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
    public function destroy(Boleto $boleto)
    {
        $response = BoletoRepository::delete($boleto);
        return response($response, $response['code']);
    }
}
