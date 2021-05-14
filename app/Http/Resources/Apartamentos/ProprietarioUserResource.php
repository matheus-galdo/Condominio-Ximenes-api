<?php

namespace App\Http\Resources\Apartamentos;

use Illuminate\Http\Resources\Json\JsonResource;

class ProprietarioUserResource extends JsonResource
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
            'id' => $this->user_id,
            'proprietario_id' => $this->id,
            'telefone' => $this->telefone,
            'aprovado' => $this->aprovado,

            'name' => $this->user->name,
            'typeName' => $this->user->typeName->nome,
            'email' => $this->user->email,
        ];
        
    }
}
