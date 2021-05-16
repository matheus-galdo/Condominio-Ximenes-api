<?php

namespace App\Http\Resources\Boletos;

use Illuminate\Http\Resources\Json\JsonResource;

class BoletoResource extends JsonResource
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
            "cadastrado_por_user_id" => $this->cadastrado_por_user_id,
            "data_pagamento" => $this->data_pagamento,
            "created_at" => $this->created_at,
            "deleted_at" => $this->deleted_at
        ];        
    }
}
