<?php

namespace App\Http\Requests\Proprietarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProprietarioRequest extends FormRequest
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

            'name' => 'required_without:ativar|string',
            'email' => 'required_without:ativar|email:rfc',
            'password' => 'nullable|min:8|confirmed',
            'userType' => 'required_without:ativar|exists:App\Models\Sistema\UserType,id',
            'celular' => 'sometimes|nullable|string|min:8',

                
            'apartamento' => 'required_without:ativar|array|exists:App\Models\Apartamento,id',
        ];
    }
}
