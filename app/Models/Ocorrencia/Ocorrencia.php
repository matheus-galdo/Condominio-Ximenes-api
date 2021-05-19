<?php

namespace App\Models\Ocorrencia;

use App\Models\Apartamento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ocorrencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'assunto',
        'autor_id',
        'apartamento_id',
        'deleted_at'
    ];

    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class);
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function followup()
    {
        return $this->hasMany(OcorrenciaFollowup::class);
    }    
}
