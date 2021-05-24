<?php

namespace App\Models;

use App\Models\Sistema\Modulos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloTexto extends Model
{
    use HasFactory;

    public $table = 'modulos_textos';

    public $fillable = [
        'modulo_sistema_id',
        'conteudo',
    ];


    public function modulos()
    {
        return $this->belongsTo(Modulos::class, 'modulo_sistema_id');
    }
}
