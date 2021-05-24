<?php

namespace App\Models\PrestacaoContas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoConta extends Model
{
    use HasFactory;

    public $fillable = [
        'nome',
        'conta_arquivo_id',
    ];

    public function arquivoContas()
    {
        return $this->belongsTo(ArquivoConta::class);
    }

    public function contas()
    {
        return $this->hasMany(Conta::class);
    }
}