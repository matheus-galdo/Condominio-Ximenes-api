<?php

namespace App\Models\Ocorrencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoFollowupAnexos extends Model
{
    use HasFactory;

    public $table = 'ocorrencia_anexos';

    protected $fillable = [
        'nome_original',
        'extensao',
        'path',
        'ocorrencia_followup_id'
    ];

    protected $hidden = [
        'path'
    ];

    public function ocorrenciaFollowup()
    {
        return $this->belongsTo(OcorrenciaFollowup::class, 'ocorrencia_followup_id');
    }

}
