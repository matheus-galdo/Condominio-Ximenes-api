<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuarios\CreateUserRequest;
use App\Http\Requests\Usuarios\UpdateUserRequest;
use App\Http\Resources\PublicUserResource;
use App\Models\Sistema\UserType;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = User::with('typeName')->whereHas('typeName', function ($builder){
            $builder->where('is_admin', true);
        })->withTrashed()->orderBy('deleted_at')->orderBy('name');

        if($request->page) return response($builder->paginate(15));
        return response($builder->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $response = UserRepository::create($request);
        return response($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        $user = User::withTrashed()->find($userId);
        return response(new PublicUserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $userId)
    {
        $response = UserRepository::update($request, $userId);
        return response($response, $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        $user = User::withTrashed()->find($userId);
        $response = UserRepository::delete($user);
        return response($response, $response['code']);
    }
}
