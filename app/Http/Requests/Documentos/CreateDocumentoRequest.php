<?php

namespace App\Http\Requests\Documentos;

use Illuminate\Foundation\Http\FormRequest;

class CreateDocumentoRequest extends FormRequest
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
            'nome_arquivo' => 'required|string|min:3',
            'arquivos' => 'required|array',
            'publico' => 'present|string',
            'data_expiracao' => 'nullable|date',

            'arquivos.*' => 'required|file',

        ];
    }
}
