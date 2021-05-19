<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aviso extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'titulo',
        'descricao',
        'user_id',
        'data_expiracao',
        'deleted_at'
    ];

    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
