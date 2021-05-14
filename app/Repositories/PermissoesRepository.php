<?php

namespace App\Repositories;

use App\Models\Sistema\Modulos;
use App\Models\Sistema\Permissoes;
use App\Models\Sistema\UserType;

class PermissoesRepository
{

    public static function create(UserType $userType, $permissao)
    {
        $modulo = Modulos::findOrFail($permissao->modulo_sistema_id);

        Permissoes::create([
            'user_type_id' => $userType->id,
            'modulo_sistema_id' => $modulo->id,
            'acessar' => $permissao->acessar,
            'visualizar' => $permissao->visualizar,
            'gerenciar' => $permissao->gerenciar,
            'criar' => $permissao->criar,
            'editar' => $permissao->editar,
            'excluir' => $permissao->excluir,
        ]);
    }

    public static function createInternal($userType)
    {
        $modulosInternal = Modulos::where('interno', true)->get();
        
        foreach ($modulosInternal as $moduloInterno) {
            Permissoes::create([
                'user_type_id' => $userType->id,
                'modulo_sistema_id' => $moduloInterno->id,
                'acessar' => self::defineInternalPemissao($moduloInterno, $userType),
                'visualizar' => self::defineInternalPemissao($moduloInterno, $userType),
                'gerenciar' => false,
                'criar' => false,
                'editar' => false,
                'excluir' => false,
            ]);
        }
    }

    private static function defineInternalPemissao($moduloInterno, $userType)
    {
        if($moduloInterno->nome == 'listar-permissoes-admin'){
            return $userType->is_admin;
        }

        return true;
    }

    public static function update($permissao)
    {
        $savedPermissao = Permissoes::findOrFail($permissao->id);

        $savedPermissao->acessar = $permissao->acessar;
        $savedPermissao->visualizar = $permissao->visualizar;
        $savedPermissao->gerenciar = $permissao->gerenciar;
        $savedPermissao->criar = $permissao->criar;
        $savedPermissao->editar = $permissao->editar;
        $savedPermissao->excluir = $permissao->excluir;

        $savedPermissao->save();
    }
}
