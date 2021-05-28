<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\Proprietarios\ApartamentosProprietarioResource;
use App\Http\Resources\Proprietarios\UserProprietarioResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatProprietariosResourceWithChatPortaria extends JsonResource
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

            'proprietario_id' => $this->id,
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'telefone' => $this->telefone,
            'chat' => $this->chatPortaria,
            

            'apartamentos' => ApartamentosProprietarioResource::collection($this->apartamentos)   
        ];
    }
}
