<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use HasFactory, SoftDeletes;
    
    public $fillable = [
        'nome',
        'nome_original',
        'extensao',
        'is_public',
        'data_expiracao',
        'path'
    ];

    public $casts = ['is_public' => 'boolean'];
}
