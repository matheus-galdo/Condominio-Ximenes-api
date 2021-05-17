<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proprietarios\CreateProprietarioRequest;
use App\Http\Requests\Proprietarios\UpdateProprietarioRequest;
use App\Http\Resources\Proprietarios\UserProprietarioResource;
use App\Models\Proprietario;
use App\Models\User;
use App\Repositories\ProprietarioRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProprietariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $defaultOrder = 'proprietarios.aprovado';
        $order = 'data_criacao';

        $orderByOptions = [
            'aprovados' => 'proprietarios.aprovado',
            'nao_aprovados' => ['proprietarios.aprovado', 'DESC'],
            'data_criacao' => ['users.created_at', 'ASC'],
            'data_criacao_desc' => ['users.created_at', 'DESC'],
            'deletados' => ['proprietarios.deleted_at'],
        ];

        $builder = User::with([
            'typeName' => function ($builder) {
                $builder->where('is_admin', false);
            },
        ])
            ->join('proprietarios', 'users.id', '=', 'proprietarios.user_id')
            ->addSelect('*', 'proprietarios.id as proprietario_id', 'users.id as id')
            ->orderBy(...$orderByOptions[$order])
            ->withTrashed();

        if ($request->page) return response($builder->paginate(15));
        return response($builder->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProprietarioRequest $request)
    {
        $response = ProprietarioRepository::create($request);
        return response($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proprietario  $proprietario
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        $proprietario = User::withTrashed()->has('proprietario')->with(['typeName', 'proprietario.apartamentos'])
            ->whereHas('typeName', function ($builder) {
                $builder->where('is_admin', false);
            })->withTrashed()->find($userId);


        return response(new UserProprietarioResource($proprietario));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proprietario  $proprietario
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProprietarioRequest $request, $userId)
    {
        $response = ProprietarioRepository::update($request, $userId);
        return response($response, $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proprietario  $proprietario
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        $user = User::withTrashed()->find($userId);
        $response = ProprietarioRepository::delete($user);
        return response($response, $response['code']);
    }
}
