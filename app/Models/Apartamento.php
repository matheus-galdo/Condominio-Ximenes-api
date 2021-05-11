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

    public function proprietarios()
    {
        return $this->belongsTo(Proprietario::class);
    }
}
