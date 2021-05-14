<?php

namespace App\Http\Resources\Apartamentos;

use Illuminate\Http\Resources\Json\JsonResource;

class ApartamentoProprietarioResource extends JsonResource
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
            'andar' => $this->andar,
            'bloco' => $this->bloco,
            'numero' => $this->numero,
            'deleted_at' => $this->deleted_at,

            'proprietarios' => ProprietarioUserResource::collection($this->proprietarios)
        ];
        
    }
}
