<?php

namespace App\Http\Requests\Apartamentos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartamentoRequest extends FormRequest
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

            'bloco' => 'required_without:ativar|string',
            'numero' => 'required_without:ativar|string',
            'andar' => 'required_without:ativar|string',
        ];
    }
}
