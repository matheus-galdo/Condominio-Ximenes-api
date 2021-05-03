<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleto extends Model
{
    use HasFactory;

    public $fillable = [
        'nome',
        'valor',
        'codigo_barras',
        'vencimento',
        'pago',
        'path',
        'user_id',
        'cadastrado_por_user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
