<?php

namespace App\Http\Resources\Proprietarios;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProprietarioResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'typeName' => $this->typeName->nome,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
            'email_verified_at' => $this->email_verified_at,
            

            'telefone' => $this->proprietario->telefone,
            'aprovado' => $this->proprietario->aprovado,


            'apartamentos' => ApartamentosProprietarioResource::collection($this->proprietario->apartamentos)        
        ];
    }
}
