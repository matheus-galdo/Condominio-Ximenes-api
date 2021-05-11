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

    public static function update($permissao)
    {
        $savedPermissao = Permissoes::findOrFail($permissao->modulo_sistema_id);

        $savedPermissao->acessar = $permissao->acessar;
        $savedPermissao->visualizar = $permissao->visualizar;
        $savedPermissao->gerenciar = $permissao->gerenciar;
        $savedPermissao->criar = $permissao->criar;
        $savedPermissao->editar = $permissao->editar;
        $savedPermissao->excluir = $permissao->excluir;

        $savedPermissao->save();
    }
}
