<?php

namespace App\Repositories;

use App\Models\Sistema\Modulos;
use App\Models\Sistema\Permissoes;
use App\Models\Sistema\UserType;
use Illuminate\Support\Facades\DB;

class UserTypeRepository
{

    public static function create($request)
    {
        try {
            DB::transaction(function () use ($request) {

                $userType = UserType::create([
                    'nome' => $request->nome,
                ]);

                foreach ($request->permissoes as $permissao) {
                    PermissoesRepository::create($userType, (object) $permissao);
                }

                PermissoesRepository::createInternal($userType);
                
            });

            return ['status' => true, 'code' => 201];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function update($request, $id)
    {
        try {
            $userType = UserType::withTrashed()->with(['permissoes', 'permissoes.modulo'])->findOrFail($id);

            if (isset($request->ativar)) {
                
                if($request->ativar){
                    $userType->restore();
                    $userType->users()->restore();
                }else{
                    $userType->delete();
                    $userType->users()->delete();
                }
            
            
            } else {
                DB::transaction(function () use ($request, $userType) {
                    $userType->nome = $request->nome;
                    $userType->is_admin = $request->isAdmin;

                    foreach ($request->permissoes as $permissao) {
                        PermissoesRepository::update((object) $permissao);
                    }

                    $userType->save();
                });
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    /**
     * delete or soft delete a resource
     *
     * @param  mixed $userType
     * @return void
     */
    public static function delete(UserType $userType)
    {
        try {
            if ($userType->default_user || $userType->default_admin) {
                return ['error' => 'o recurso não pode ser excluido', 'code' => 403];
            }
            
            if($userType->trashed()){
                $userType->forceDelete();
                $userType->users()->forceDelete();
            }
            
            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}
