<?php

namespace App\Http\Requests\Documentos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentoRequest extends FormRequest
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

            'nome_arquivo' => 'required_without:ativar|string|min:3',
            'publico' => 'sometimes|boolean',
            'data_expiracao' => 'sometimes|nullable|date'
        ];
    }
}
