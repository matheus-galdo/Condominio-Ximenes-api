<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicUserResource extends JsonResource
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
            'permissoes' => PermissoesWithModulosResource::collection($this->typeName->accessablePermissoesWithModulo),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
        
    }
}
