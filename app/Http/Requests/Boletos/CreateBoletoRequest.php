<?php

namespace App\Http\Requests\Boletos;

use Illuminate\Foundation\Http\FormRequest;

class CreateBoletoRequest extends FormRequest
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
            'despesa' => 'required|string|min:3',
            'apartamento' => 'required|exists:App\Models\Apartamento,id',
            'arquivos' => 'required|array',
            'arquivos.*' => 'required|file|mimetypes:application/pdf',
        ];
    }
}
