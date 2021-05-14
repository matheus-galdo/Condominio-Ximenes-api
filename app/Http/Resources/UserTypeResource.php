<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'nome' => $this->nome,
            'deleted_at' => $this->deleted_at,
            'is_admin' => $this->is_admin,
        ];

        if ($this->accessablePermissoesWithModulo) {
            $resource['permissoes_with_modulo'] = $this->accessablePermissoesWithModulo;
        }

        return $resource;
    }
}
