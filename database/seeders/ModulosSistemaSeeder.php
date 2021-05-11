<?php

namespace Database\Seeders;

use App\Models\Sistema\Modulos;
use Illuminate\Database\Seeder;

class ModulosSistemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modulos = [
            ['nome'=>'dashboard',         'label' => 'Tela inicial',                'descricao' => 'Tela inicial com todos os avisos'],
            ['nome'=>'avisos',            'label' => 'Avisos',                      'descricao' => 'Cadastro e gerencimaneto de avisos '],
            ['nome'=>'locatarios',        'label' => 'Autorização de entrada',      'descricao' => 'Cadastro e visualização de locatários'],
            ['nome'=>'ocorrencias',       'label' => 'Ocorrências',                 'descricao' => 'Cadastro, visualização e gerencimaneto de ocorrências'],
            ['nome'=>'documentos',        'label' => 'Documentos',                  'descricao' => 'Cadastro, visualização e gerencimaneto de documentos'],
            ['nome'=>'boletos',           'label' => 'Boletos',                     'descricao' => 'Cadastro, visualização e gerencimaneto de ocorrências'],
            ['nome'=>'chat-sindica',      'label' => 'Fale com a síndica',          'descricao' => 'lorem impsum'],
            ['nome'=>'chat-portaria',     'label' => 'Fale com a portaria',         'descricao' => 'lorem impsum'],
            ['nome'=>'proprietarios',     'label' => 'Proprietários',               'descricao' => 'lorem impsum'],
            ['nome'=>'apartamentos',      'label' => 'Apartamentos',                'descricao' => 'lorem impsum'],
            ['nome'=>'usuarios',          'label' => 'Usuários',                    'descricao' => 'lorem impsum'],
            ['nome'=>'permissoes',        'label' => 'Permissões',                  'descricao' => 'lorem impsum'],
            ['nome'=>'prestacao-contas',  'label' => 'prestação de contas',         'descricao' => 'lorem impsum'],
            ['nome'=>'regras-normas',     'label' => 'Regras e normas',             'descricao' => 'lorem impsum'],
            ['nome'=>'contatos',          'label' => 'Contatos',                    'descricao' => 'lorem impsum'],
            ['nome'=>'funcionamento',     'label' => 'Horário de Funcionamento',    'descricao' => 'lorem impsum'],
            ['nome'=>'conta',             'label' => 'Minha conta',                 'descricao' => 'lorem impsum'],

            ['nome'=>'modulos',           'label' => 'Módulos do sistema',          'descricao' => ''],
        ];

        foreach ($modulos as $modulo) {
            Modulos::create([
                'nome' => $modulo['nome'],
                'label' => $modulo['label'],
                'descricao' => $modulo['descricao'],
            ]);
        }
    }
}
