<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proprietario extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'apartamento_id',
        'telefone'
    ];
    
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function apartamentos(){
        return $this->belongsToMany(Apartamento::class, 'apartamentos_proprietarios');
    }
}
