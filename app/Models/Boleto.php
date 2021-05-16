<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boleto extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'nome',
        'valor',
        'codigo_barras',
        'vencimento',
        'pago',
        'path',
        'apartamento_id',
        'cadastrado_por_user_id',
        'deleted_at'
    ];

    public $casts = [
        'pago' => 'boolean',
        'vencimento' => 'datetime',
        'data_pagamento' => 'datetime'
    ];


    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class);
    }

    public function cadastradoPor()
    {
        return $this->belongsTo(User::class, 'cadastrado_por_user_id');
    }
}
