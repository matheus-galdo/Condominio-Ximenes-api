<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permissoes\CreateUserTypeRequest;
use App\Http\Requests\Permissoes\UpdateUserTypeRequest;
use App\Http\Resources\UserTypeResource;
use App\Models\Sistema\UserType;
use App\Repositories\UserTypeRepository;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(UserType::withTrashed()->orderBy('nome')->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateUserTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserTypeRequest $request)
    {
        $response = UserTypeRepository::create($request);
        return response($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sistema\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function show($userTypeId)
    {
        $userType = UserType::withTrashed()->with(['permissoesWithModulo'])->find($userTypeId);

        foreach ($userType->permissoesWithModulo as $key => $value) {
            if ($value->modulo['nome'] == 'modulos') {
                unset($userType->permissoesWithModulo[$key]);
            }
        }

        return response($userType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserTypeRequest  $request
     * @param  \App\Models\Sistema\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserTypeRequest $request, $userTypeId)
    {
        $response = UserTypeRepository::update($request, $userTypeId);
        return response($response, $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sistema\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function destroy($userTypeId)
    {
        $userType = UserType::withTrashed()->find($userTypeId);
        $response = UserTypeRepository::delete($userType);
        return response($response, $response['code']);
    }
}
