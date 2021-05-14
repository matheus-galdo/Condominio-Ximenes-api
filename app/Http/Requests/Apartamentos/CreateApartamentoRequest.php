<?php

namespace App\Http\Requests\Apartamentos;

use Illuminate\Foundation\Http\FormRequest;

class CreateApartamentoRequest extends FormRequest
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
            'bloco' => 'required|string',
            'numero' => 'required|string',
            'andar' => 'required|string',
        ];
    }
}
