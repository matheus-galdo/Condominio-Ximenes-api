<?php

namespace App\Models\Ocorrencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OcorrenciaFollowup extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'ocorrencia_followup';

    protected $fillable = [
        'descricao',
        'evento_followup_id',
        'ocorrencia_id',
        'responsavel_id'
    ];


    public function ocorrencia()
    {
        return $this->belongsTo(Ocorrencia::class);
    }

    public function evento()
    {
        return $this->belongsTo(EventoFollowup::class, 'evento_followup_id');
    }

    public function anexos()
    {
        return $this->hasMany(EventoFollowupAnexos::class);
    }
}
