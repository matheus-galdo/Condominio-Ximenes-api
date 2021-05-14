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
            ['nome'=>'listar-permissoes-admin', 'label' => 'Listar permissoes',     'descricao' => '', 'interno' => true],
            ['nome'=>'listar-permissoes-user',  'label' => 'Listar permissoes',     'descricao' => '', 'interno' => true],
            ['nome'=>'download-file',           'label' => 'Download Documento',    'descricao' => '', 'interno' => true],
            ['nome'=>'modulos',                 'label' => 'Módulos do sistema',    'descricao' => '', 'interno' => true],

            
            

            ['nome'=>'dashboard',         'label' => 'Tela inicial',                'descricao' => 'Tela inicial com todos os avisos',                          'interno' => false],
            ['nome'=>'avisos',            'label' => 'Avisos',                      'descricao' => 'Cadastro e gerencimaneto de avisos ',                       'interno' => false],
            ['nome'=>'locatarios',        'label' => 'Autorização de entrada',      'descricao' => 'Cadastro e visualização de locatários',                     'interno' => false],
            ['nome'=>'ocorrencias',       'label' => 'Ocorrências',                 'descricao' => 'Cadastro, visualização e gerencimaneto de ocorrências',     'interno' => false],
            ['nome'=>'documentos',        'label' => 'Documentos',                  'descricao' => 'Cadastro, visualização e gerencimaneto de documentos',      'interno' => false],
            ['nome'=>'boletos',           'label' => 'Boletos',                     'descricao' => 'Cadastro, visualização e gerencimaneto de ocorrências',     'interno' => false],
            ['nome'=>'chat-sindica',      'label' => 'Fale com a síndica',          'descricao' => 'lorem impsum',                                              'interno' => false],
            ['nome'=>'chat-portaria',     'label' => 'Fale com a portaria',         'descricao' => 'lorem impsum',                                              'interno' => false],
            ['nome'=>'proprietarios',     'label' => 'Proprietários',               'descricao' => 'lorem impsum',                                              'interno' => false],
            ['nome'=>'apartamentos',      'label' => 'Apartamentos',                'descricao' => 'lorem impsum',                                              'interno' => false],
            ['nome'=>'usuarios',          'label' => 'Usuários',                    'descricao' => 'lorem impsum',                                              'interno' => false],
            ['nome'=>'permissoes',        'label' => 'Permissões',                  'descricao' => 'lorem impsum',                                              'interno' => false],
            ['nome'=>'prestacao-contas',  'label' => 'prestação de contas',         'descricao' => 'lorem impsum',                                              'interno' => false],
            ['nome'=>'regras-normas',     'label' => 'Regras e normas',             'descricao' => 'lorem impsum',                                              'interno' => false],
            ['nome'=>'contatos',          'label' => 'Contatos',                    'descricao' => 'lorem impsum',                                              'interno' => false],
            ['nome'=>'funcionamento',     'label' => 'Horário de Funcionamento',    'descricao' => 'lorem impsum',                                              'interno' => false],
            ['nome'=>'conta',             'label' => 'Minha conta',                 'descricao' => 'lorem impsum',                                              'interno' => false],
        ];

        foreach ($modulos as $modulo) {
            Modulos::create([
                'nome' => $modulo['nome'],
                'label' => $modulo['label'],
                'descricao' => $modulo['descricao'],
                'interno' => $modulo['interno'],
            ]);
        }
    }
}
