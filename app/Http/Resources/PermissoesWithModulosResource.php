<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissoesWithModulosResource extends JsonResource
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
            'modulo_id' => $this->modulo_sistema_id,
            'modulo' => $this->modulo->nome,
            'label' => $this->modulo->label,
            'acessar' => $this->acessar,
            'criar' => $this->criar,
            'editar' => $this->editar,
            'excluir' => $this->excluir,
            'gerenciar' => $this->gerenciar,
            'visualizar' => $this->visualizar,
        ];
    }
}
