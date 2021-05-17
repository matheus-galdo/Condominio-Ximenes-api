<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocatarioConvidado extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'cpf',
        'celular',
        'crianca',
        'observacoes',
        'locatario_id'
    ];


    public function locatario()
    {
        return $this->belongsTo(Locatario::class);
    }
}
