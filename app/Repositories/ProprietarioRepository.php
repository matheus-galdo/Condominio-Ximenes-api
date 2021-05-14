<?php

namespace App\Repositories;

use App\Models\Apartamento;
use App\Models\ApartamentosProprietario;
use App\Models\Proprietario;
use App\Models\Sistema\UserType;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProprietarioRepository
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
            if (!in_array($request->userType, UserType::getAvailableTypes(false))) throw new \Exception("Tipo de usuário não compatível", 1);
                
            DB::transaction(function () use($request) {
                $user = User::create([
                    'name' => $request->name,
                    'type' => $request->userType,
                    'email' => $request->email,
                    'password' => password_hash($request->password, PASSWORD_BCRYPT)
                ]);

                $proprietario = Proprietario::create([
                    'user_id' => $user->id,
                    'aprovado' => true,
                    'telefone' => (!empty($request->telefone))? $request->telefone: 'atualizar'
                ]);

                $proprietario->apartamentos()->attach($request->apartamento);

                $user->typeName()->restore();
            });

            return ['status' => true, 'code' => 201];

        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
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

            } elseif(isset($request->aprovar)) {
                $user->proprietario()->aprovado = true;
                $user->save();

            } else {

                if (!in_array($request->userType, UserType::getAvailableTypes(false))) throw new \Exception("Tipo de usuário não compatível", 1);
                
                DB::transaction(function () use($request, $user) {
                    
                    $savedApartamentos = $user->proprietario->apartamentos->keyBy('id');
                    
                    foreach ($request->apartamento as $apartamentoId) {
                        $savedApartamentoProprietario = $savedApartamentos->firstWhere('id', $apartamentoId);
                        
                        if (!empty($savedApartamentoProprietario)) {
                            $savedApartamentos->forget($apartamentoId);
                        }else{
                            $user->proprietario->apartamentos()->attach($apartamentoId);
                        }
                    }

                    $apartamentosToDelete = $savedApartamentos->pluck('id');
                    if($apartamentosToDelete->count() > 0)$user->proprietario->apartamentos()->detach($apartamentosToDelete);


                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->type = $request->userType;
                    $user->proprietario->telefone = (!empty($request->celular))? $request->celular: 'atualizar' ;                    
                    if (isset($request->password)) $user->password = password_hash($request->password, PASSWORD_BCRYPT);
                    
                    $user->push();
                    return ['status' => $savedApartamentos, 'code' => 201];
                });
            }

            return ['status' => true, 'code' => 200];
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
