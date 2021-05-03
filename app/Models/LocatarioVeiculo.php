<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocatarioVeiculo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'placa',
        'modelo',
        'cor',
        'locatario_id'
    ];

    public function locatario()
    {
        return $this->belongsTo(Locatario::class);
    }
}
