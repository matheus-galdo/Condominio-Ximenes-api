<?php

namespace App\Http\Requests\Locatario;

use Illuminate\Foundation\Http\FormRequest;

class CreateLocatarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       
        return isAuthorized(['admin', 'morador']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nomeLocatario' => 'string|required',
            'cpf' => 'string|required',
            'dataChegada' => 'required|date|after_or_equal:today',
            'dataSaida' => 'required|date|after:start_date',
            'celular' => 'string|required',
            'email' => 'required|email:rfc,dns',
            'observacoes' => 'string|present|nullable',

            'veiculos' => 'present|array',
            'convidados' => 'present|array',

            'veiculos.placa' => 'string|required_if:veiculos,min:1',
            // 'veiculos.modelo' => 'required',
            // 'veiculos.cor' => 'required',

            // 'convidados.nome' => 'required',
            // 'convidados.cpf' => 'required',
            // 'convidados.celular' => 'required',
            // 'convidados.email' => 'required',
            // 'convidados.observacoes' => 'required'
        ];
    }

}
