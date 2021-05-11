<?php

namespace Database\Seeders;

use App\Models\Sistema\Modulos;
use App\Models\Sistema\Permissoes;
use App\Models\Sistema\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissoesSeeder extends Seeder
{

    public const BASE_PERMISSIONS = [
        'admin' => ['acessar' => true, 'visualizar' => true, 'gerenciar' => true, 'criar' => true, 'editar' => true, 'excluir' => true],
        'sindica' => ['acessar' => true, 'visualizar' => true, 'gerenciar' => true, 'criar' => true, 'editar' => true, 'excluir' => true],
        'porteiro' => ['acessar' => true, 'visualizar' => true, 'gerenciar' => true, 'criar' => true, 'editar' => true, 'excluir' => true],
        'morador' => ['acessar' => true, 'visualizar' => true, 'gerenciar' => true, 'criar' => true, 'editar' => true, 'excluir' => true],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $userTypes = UserType::get()->keyBy('id');
        $modulosSistema = Modulos::get()->keyBy('id');

        foreach ($userTypes as $typeId => $userType) {
            foreach ($modulosSistema as $moduloId => $modulo) {
                Permissoes::create([
                    'user_type_id' => $typeId,
                    'modulo_sistema_id' => $moduloId,
                    'acessar'=> self::BASE_PERMISSIONS[$userType->nome]['acessar'],
                    'visualizar'=> self::BASE_PERMISSIONS[$userType->nome]['visualizar'],
                    'gerenciar'=> self::BASE_PERMISSIONS[$userType->nome]['gerenciar'],
                    'criar'=> self::BASE_PERMISSIONS[$userType->nome]['criar'],
                    'editar'=> self::BASE_PERMISSIONS[$userType->nome]['editar'],
                    'excluir'=> self::BASE_PERMISSIONS[$userType->nome]['excluir']
                ]);
            }
        }
    }
}
