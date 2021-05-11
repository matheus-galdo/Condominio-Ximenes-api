<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissoesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_type_id' => 'required',
            'modulo_sistema_id' => 'required',

            'permissoes' => 'required|array',
            'permissoes.*.visualizar' => 'required',
            'permissoes.*.gerenciar' => 'required',
            'permissoes.*.criar' => 'required',
            'permissoes.*.editar' => 'required',
            'permissoes.*.excluir' => 'required',
        ];
    }
}
