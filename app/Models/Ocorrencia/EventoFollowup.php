<?php

namespace App\Models\Ocorrencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoFollowup extends Model
{
    use HasFactory;

    public $table = 'evento_followup';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'cor',
    ];

    public function ocorrenciaFollowup()
    {
        return $this->hasMany(OcorrenciaFollowup::class);
    }

}
