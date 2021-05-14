<?php

namespace App\Repositories;

use App\Models\Apartamento;
use App\Models\Sistema\UserType;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{

    /**
     * create
     *
     * @param  mixed $request
     * @return void
     */
    public static function create($request)
    {
        try {
            DB::transaction(function () use($request) {
                if (!in_array($request->userType, UserType::getAvailableTypes(true))) throw new \Exception("Tipo de usuário não compatível", 1);

                $user = User::create([
                    'name' => $request->name,
                    'type' => $request->userType,
                    'email' => $request->email,
                    'password' => password_hash($request->password, PASSWORD_BCRYPT)
                ]);
    
                $user->typeName()->restore();
            });

            return ['status' => true, 'code' => 201];

        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function show($id)
    {
        try {
            $user = User::with(['typeName.permissoes'])->withTrashed()->findOrFail($id)->toArray();
            $user['code'] = 201;
            return $user;
        } catch (\Throwable $th) {
            //throw $th;
            return ['error' => $th, 'code' => 400];
        }
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $apartamento
     * @return void
     */
    public static function update($request, $id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);

            if (isset($request->ativar)) {
                if ($request->ativar) {
                    $user->restore();
                    $user->typeName()->restore();
                } else {
                    $user->delete();
                }

            } else {
                if (!in_array($request->userType, UserType::getAvailableTypes(true))) throw new \Exception("Tipo de usuário não compatível", 1);

                $user->name = $request->name;
                $user->email = $request->email;
                $user->type = $request->userType;

                if (isset($request->password)) $user->password = password_hash($request->password, PASSWORD_BCRYPT);

                $user->save();
            }

            return ['status' => true, 'code' => 201];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function delete($user)
    {
        try {
            if ($user->trashed()) {
                $user->forceDelete();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}
