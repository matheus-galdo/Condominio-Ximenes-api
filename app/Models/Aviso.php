<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    use HasFactory;

    public $fillable = [
        'titulo',
        'descricao',
        'user_id',
        'data_expiracao'
    ];

}
