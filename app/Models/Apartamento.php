<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartamento extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    public $fillable = [
        'bloco',
        'numero',
        'andar'
    ];

    public $casts = ['numero' => 'string'];

    public function proprietarios()
    {
        return $this->belongsToMany(Proprietario::class, 'apartamentos_proprietarios');
    }

    public function boletos()
    {
        return $this->hasMany(Boleto::class);
    }
}
