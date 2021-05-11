<?php

namespace App\Http\Requests\Permissoes;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserTypeRequest extends FormRequest
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
            'ativar' => 'nullable|boolean',


            'nome' => 'required_without:ativar|string',
            'isAdmin' => 'required_without:ativar|boolean',

            'permissoes' => 'required_without:ativar|array',
            'permissoes.*.modulo_sistema_id' => 'numeric|required|exists:App\Models\Sistema\Permissoes,id',
            'permissoes.*.acessar' => 'boolean|required',
            'permissoes.*.visualizar' => 'boolean|required',
            'permissoes.*.gerenciar' => 'boolean|required',
            'permissoes.*.criar' => 'boolean|required',
            'permissoes.*.editar' => 'boolean|required',
            'permissoes.*.excluir' => 'boolean|required'
        ];
    }
}
