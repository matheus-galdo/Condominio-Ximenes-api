<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locatario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'data_chegada',
        'data_saida',
        'celular',
        'email',
        'observacoes',
        'possui_veiculos',
        'possui_convidados',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function veiculos()
    {
        return $this->hasMany(LocatarioVeiculo::class);
    }

    public function convidados()
    {
        return $this->hasMany(LocatarioConvidado::class);
    }
}
