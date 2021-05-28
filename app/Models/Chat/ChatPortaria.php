<?php

namespace App\Models\Chat;

use App\Models\Proprietario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatPortaria extends Model
{
    use HasFactory;

    public $table = 'chat_portaria';
    public $timestamps = false;
    
    public $fillable = [
        "proprietario_id"
    ];

    public function proprietario()
    {
        return $this->belongsTo(Proprietario::class); 
    }

    public function mensagens()
    {
        return $this->hasMany(ChatPortariaMensagens::class);
    }

    public function ultimaMensagem()
    {
        return $this->hasOne(ChatPortariaMensagens::class)->latest();
    }
}