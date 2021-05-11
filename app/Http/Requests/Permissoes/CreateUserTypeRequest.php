<?php

namespace App\Http\Requests\Permissoes;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|string|unique:App\Models\Sistema\UserType,nome',
            'isAdmin' => 'present|boolean',

            'permissoes' => 'required|array',
            'permissoes.*.modulo_sistema_id' => 'numeric|required',
            'permissoes.*.acessar' => 'boolean|required',
            'permissoes.*.visualizar' => 'boolean|required',
            'permissoes.*.gerenciar' => 'boolean|required',
            'permissoes.*.criar' => 'boolean|required',
            'permissoes.*.editar' => 'boolean|required',
            'permissoes.*.excluir' => 'boolean|required'
        ];
    }
}
