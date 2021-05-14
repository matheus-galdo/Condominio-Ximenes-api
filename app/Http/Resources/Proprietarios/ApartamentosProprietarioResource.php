<?php

namespace App\Http\Resources\Proprietarios;

use Illuminate\Http\Resources\Json\JsonResource;

class ApartamentosProprietarioResource extends JsonResource
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
            'bloco' => $this->bloco,
            'numero' => $this->numero,
            'andar' => $this->andar,
        
        ];
    }
}
