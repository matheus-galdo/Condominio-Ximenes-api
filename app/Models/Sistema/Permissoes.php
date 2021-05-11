<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissoes extends Model
{
    use HasFactory;

    public $table = 'permissoes';
    public $timestamps = false;

    public $fillable = [
        'user_type_id',
        'modulo_sistema_id',
        'acessar',
        'visualizar',
        'gerenciar',
        'criar',
        'editar',
        'excluir'
    ];

    public $casts = [
        'acessar' => 'boolean',
        'visualizar' => 'boolean',
        'gerenciar' => 'boolean',
        'criar' => 'boolean',
        'editar' => 'boolean',
        'excluir' => 'boolean'
    ];


    public function uerType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    public function modulo()
    {
        return $this->belongsTo(Modulos::class, 'modulo_sistema_id');
    }
}
