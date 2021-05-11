<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoFollowup extends Model
{
    use HasFactory;

    public $table = 'evento_followup';

    public $timestamps = false;

    protected $fillable = [
        'nome'
    ];
}
