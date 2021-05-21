<?php

namespace App\Http\Requests\Ocorrencias;

use Illuminate\Foundation\Http\FormRequest;

class CreateOcorrenciaRequest extends FormRequest
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
            'assunto' => 'required|string',
            'descricao' => 'required|string',
            'apartamento' => 'required|exists:App\Models\Apartamento,id',

            'arquivos' => 'sometimes|array',
            'arquivos.*' => 'required|file',
        ];

    }
}
