<?php

namespace App\Http\Requests\Proprietarios;

use Illuminate\Foundation\Http\FormRequest;

class CreateProprietarioRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email:rfc|unique:App\Models\User,email',
            'password' => 'required|confirmed',
            'userType' => 'required|exists:App\Models\Sistema\UserType,id',
            'celular' => 'present|nullable|string|min:8',
            
            'apartamento' => 'required|array|exists:App\Models\Apartamento,id',
        ];
    }
}
