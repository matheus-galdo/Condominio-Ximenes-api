<?php

namespace App\Services\SearchAndFilter;

use Illuminate\Database\Eloquent\Model;

class SearchAndFilter{

    protected $table = '';
    protected $model;
    protected $builder;

    protected $availableFilters = [
        'data_cadastro_recentes',
        'data_cadastro_antigas',
        'nome',
        'extensao',
        'numero',
        'andar',
        'aprovados',
        'nao_aprovados',
        'desativado',
        'ativado'
    ];

    public function __construct(Model $model)
    {
        $this->getModelTable($model);

            $this->data_cadastro_recentes =     ['rule' => [$this->table.'.created_at', 'DESC'],         'clause' => 'orderBy'];
            $this->data_cadastro_antigas =      ['rule' => [$this->table.'.created_at', 'ASC'],          'clause' => 'orderBy'];
            $this->nome =                       ['rule' => [$this->table.'.nome', 'ASC'],                'clause' => 'orderBy'];
            $this->numero =                     ['rule' => [$this->table.'.numero', 'ASC'],              'clause' => 'orderBy'];
            $this->andar =                      ['rule' => [$this->table.'.andar', 'ASC'],               'clause' => 'orderBy'];
            $this->extensao =                   ['rule' => [$this->table.'.extensao', 'ASC'],            'clause' => 'orderBy'];

            $this->aprovados =                  ['rule' => [$this->table.'.aprovado', true],             'clause' => 'where'];
            $this->nao_aprovados =              ['rule' => [$this->table.'.aprovado', false],            'clause' => 'where'];
            $this->desativado =                 ['rule' => [$this->table.'.deleted_at', '!=', null],     'clause' => 'where'];
            $this->ativado =                    ['rule' => [$this->table.'.deleted_at', null],     'clause' => 'where'];
    }

    public function getModelTable($model)
    {
        $table = $model->table;

        if (empty($table)) {
            $fullClassName = get_class($model);
            $explodedClassName = explode("\\", $fullClassName);
            $className = end($explodedClassName);
            $className = strtolower(substr($className, 0 ,1)).substr($className, 1);
            $re_matchUppercase = '/([A-Z]+)/m';
            $result = preg_replace($re_matchUppercase, "_$1", $className);
            $table = strtolower($result);
            $table .= (substr($table,-1, 1) != 's') ? 's':'';
        }

        $this->table = $table;
        $this->model = $model;
        $this->builder = $model->newQuery();
    }


    public function getBuilderWithFilter(string $filter, $builder = null)
    {
        if (empty($builder)) {
            $builder = $this->builder;
        }

        if (empty($filter)) {
            return $builder;
        }

        if (!in_array($filter, $this->availableFilters)) {
            return $builder;
        }

        if (isset($filter) && $filter != 'todos') {
            if ($this->$filter['clause'] == 'where') {
                $builder = $builder->where(...$this->$filter['rule']);
            } else if ($this->$filter['clause'] == 'orderBy') {
                $builder = $builder->orderBy(...$this->$filter['rule']);
            }
        }

        return $builder;
    }

    public function setCustomRule($ruleName, array $rule, $clause)
    {
        $this->$ruleName = ['rule' => $rule,     'clause' => $clause];
    }
}