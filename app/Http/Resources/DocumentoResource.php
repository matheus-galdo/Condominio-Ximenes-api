<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentoResource extends JsonResource
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
            "created_at" => $this->created_at,
            "data_expiracao" => $this->data_expiracao,
            "deleted_at" => $this->deleted_at,
            "extensao" => $this->extensao,
            "id" => $this->id,
            "is_public" => $this->is_public,
            "nome" => $this->nome,
            "nome_original" => $this->nome_original
        ];
    }
}
