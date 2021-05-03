<?php

namespace App\Http\Controllers;

use App\Http\Requests\Locatario\CreateLocatarioRequest;
use App\Models\Locatario;
use App\Models\LocatarioConvidado;
use App\Models\LocatarioVeiculo;
use App\Repositories\LocatarioRepository;
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
    public function index()
    {
        return Locatario::with(['user'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLocatarioRequest $request)
    {

        LocatarioRepository::createLocatario($request);

        return 'foi';

        // return response(json_encode($t), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Locatario::with(['veiculos', 'convidados', 'user'])->find($id);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = auth()->user();
            $userType = '';
            if ($user->type !== 4) {
                $locatario = Locatario::where('user_id', $user->id)->where('id', $id)->firstOrFail();

                return response()->json($locatario);
            }
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
    }
}
