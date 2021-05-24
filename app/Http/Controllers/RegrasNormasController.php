<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterProprietarioRequest;
use App\Models\ModuloTexto;
use App\Models\Proprietario;
use App\Models\Sistema\UserType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegrasNormasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return ModuloTexto::whereHas('modulos', function ($builder){
            return $builder->where('nome', 'regras-normas');
        })->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $response = ['status' => true, 'code' => 200];

        try {
            $moduloTexto = ModuloTexto::whereHas('modulos', function ($builder){
                return $builder->where('nome', 'regras-normas');
            })->first();
            
            $moduloTexto->update([
                'conteudo' => $request->content
            ]);
        } catch (\Throwable $th) {
            $response = exceptionApi($th, 400);
        }
        
        return response($response, $response['code']);
    }
}
