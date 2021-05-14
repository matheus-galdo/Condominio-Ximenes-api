<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permissoes\CreateUserTypeRequest;
use App\Http\Requests\Permissoes\UpdateUserTypeRequest;
use App\Http\Resources\UserTypeResource;
use App\Models\Sistema\UserType;
use App\Repositories\UserTypeRepository;
use Illuminate\Http\Request;

class UserTypeListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarUsersAdmin(Request $request)
    {
        return response(UserType::where('is_admin', true)->withTrashed()->orderBy('nome')->get());
    }

    
    /**
     * listarUsersAdmin
     *
     * @param  mixed $request
     * @return void
     */
    public function listarUsers(Request $request)
    {
        return response(UserType::where('is_admin', false)->withTrashed()->orderBy('nome')->get());
    }

    


}
