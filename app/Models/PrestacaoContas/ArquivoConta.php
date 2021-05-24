<?php

namespace App\Models\PrestacaoContas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArquivoConta extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'conta_arquivos';
    
    public $fillable = [
        'nome',
        'extensao',
        'periodo',
        'path',
        'deleted_at',
    ];

    public function gruposContas()
    {
        return $this->hasMany(GrupoConta::class);
    }
}
