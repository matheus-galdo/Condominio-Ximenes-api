<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulos extends Model
{
    use HasFactory;

    public $table = 'modulos_sistema';
    public $timestamps = false;

    public $fillable = [
        'nome'
    ];

    public $casts = [
        'interno' => 'boolean'
    ];

    public function permissoes()
    {
        return $this->hasMany(Permissoes::class, 'modulo_sistema_id');
    }

    public function scopeAcessableModulos($builder)
    {
        return $builder->where('interno', false);
    }
}
