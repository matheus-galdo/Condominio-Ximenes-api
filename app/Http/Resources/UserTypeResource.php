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
            't' => $this->properties
            // 'permissoes_with_modulo' => PermissoesWithModulosResource::collection($this->permissoes_with_modulo) || null,
        ];

        // if ($this->permissoes_with_modulo) {
        //     $resource['permissoes'] = 'aaaaaaaaaa';
        // }

        return $resource;
    }
}
