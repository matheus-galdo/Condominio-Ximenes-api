<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterProprietarioRequest;
use App\Models\Proprietario;
use App\Models\Sistema\UserType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function register(RegisterProprietarioRequest $request)
    {
        try {
            
            DB::transaction(function () use ($request) {
                $userType = UserType::where('is_admin', false)->first();
                $user = User::create([
                    'name' => $request->name,
                    'type' => $userType->id,
                    'email' => $request->email,
                    'password' => password_hash($request->password, PASSWORD_BCRYPT)
                ]);

                $proprietario = Proprietario::create([
                    'user_id' => $user->id,
                    'aprovado' => false,
                    'telefone' => $request->celular,
                    'apartamento_solicitado' => $request->apartamento
                ]);
            });

            return ['status' => true, 'code' => 201];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
        
        return response()->json($request);
    }
}
