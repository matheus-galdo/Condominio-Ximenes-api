<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OcorrenciaFollowup extends Model
{
    use HasFactory;

    public $table = 'ocorrencia_followup';

    protected $fillable = [
        'descricao',
        'evento_followup_id',
        'ocorrencia_id'
    ];


    public function ocorrencia()
    {
        return $this->belongsTo(Ocorrencia::class);
    }

    public function evento()
    {
        return $this->hasOne(EventoFollowup::class);
    }

}
