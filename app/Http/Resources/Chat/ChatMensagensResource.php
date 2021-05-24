<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\Proprietarios\ApartamentosProprietarioResource;
use App\Http\Resources\Proprietarios\UserProprietarioResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMensagensResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'chat_sindica_id' => $this->chat_sindica_id,
            'mensagem' => $this->mensagem,
            'mensagem_admin' => $this->mensagem_admin,
            'anexo' => $this->anexo,
            'tipo_anexo' => $this->tipo_anexo,
            'extensao' => $this->extensao,
            'nome_original' => $this->nome_original,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            'autor' => [
                'name' => $this->autor->name,
                'user_id' => $this->autor->id,
            ]
        ];

        
    }
}
