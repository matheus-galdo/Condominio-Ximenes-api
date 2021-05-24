<?php

namespace App\Models;

use App\Models\Chat\ChatPortaria;
use App\Models\Chat\ChatSindica;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proprietario extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'telefone',
        'aprovado',
        'apartamento_solicitado'
    ];

    public $casts = [
        'aprovado' => 'boolean',
    ];
    
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function apartamentos(){
        return $this->belongsToMany(Apartamento::class, 'apartamentos_proprietarios');
    }

    public function chatSindica(){
        return $this->hasOne(ChatSindica::class);
    }

    public function chatPortaria(){
        return $this->hasOne(ChatPortaria::class);
    }
}
