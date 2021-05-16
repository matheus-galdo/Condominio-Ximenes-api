<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatSindicaMensagens extends Model
{
    use HasFactory;

    public $fillable = [
        'autor_mensagem',
        'chat_sindica_id',
        'mensagem',
        'mensagem_admin',
        'anexo',
        'tipo_anexo'
    ];

    public function chatSindica()
    {
        return $this->belongsTo(chatSindica::class);
    }
}