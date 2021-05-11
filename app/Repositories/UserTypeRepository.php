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

                $moduloInstance = Modulos::where('nome', 'modulos')->firstOrFail();
                Permissoes::create([
                    'user_type_id' => $userType->id,
                    'modulo_sistema_id' => $moduloInstance->id,
                    'acessar' => true,
                    'visualizar' => true,
                    'gerenciar' => false,
                    'criar' => false,
                    'editar' => false,
                    'excluir' => false,
                ]);
            });

            return ['status' => true, 'code' => 201];
        } catch (\Throwable $th) {
            // throw $th;
            return ['error' => $th, 'code' => 400];
        }
    }

    public static function update($request, $id)
    {
        try {
            $userType = UserType::withTrashed()->with(['permissoes', 'permissoes.modulo'])->findOrFail($id);

            if (isset($request->ativar)) {
                ($request->ativar) ? $userType->restore() : $userType->delete();
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
            // throw $th;
            return ['error' => $th, 'code' => 400];
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
            if ($userType->trashed()) {
                $userType->forceDelete();
            } else {
                $userType->delete();
            }

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            //throw $th;
            return ['error' => $th, 'code' => 400];
        }
    }
}
