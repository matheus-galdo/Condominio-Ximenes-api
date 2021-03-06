<?php

namespace App\Models\Chat;

use App\Models\Proprietario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatSindica extends Model
{
    use HasFactory;

    public $table = 'chat_sindica';
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
        return $this->hasMany(ChatSindicaMensagens::class);
    }

    public function ultimaMensagem()
    {
        return $this->hasOne(ChatSindicaMensagens::class)->latest();
    }
}
