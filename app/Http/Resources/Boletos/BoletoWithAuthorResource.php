<?php

namespace App\Http\Resources\Boletos;

use Illuminate\Http\Resources\Json\JsonResource;

class BoletoWithAuthorResource extends JsonResource
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
            "id" => $this->id,
            "nome" => $this->nome,
            "valor" => $this->valor,
            "codigo_barras" => $this->codigo_barras,
            "vencimento" => $this->vencimento,
            "pago" => $this->pago,
            "apartamento" => $this->apartamento,
            "data_pagamento" => $this->data_pagamento,
            "created_at" => $this->created_at,
            "deleted_at" => $this->deleted_at,
            "cadastrado_por" => $this->cadastradoPor
        ];        
    }
}
