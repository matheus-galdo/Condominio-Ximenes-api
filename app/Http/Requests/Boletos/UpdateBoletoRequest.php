<?php

namespace App\Http\Requests\Boletos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBoletoRequest extends FormRequest
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
            'ativar' => 'sometimes|nullable|boolean',

            'pagar' => 'sometimes|nullable|boolean',


            'despesa' => 'sometimes|string|min:3',
            'apartamento' => 'sometimes|integer|exists:App\Models\Apartamento,id',

        ];
    }
}
