<?php

namespace App\Http\Requests;

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
            'apartamento' => 'required|integer',
            'observacoes' => 'string|present|nullable',

            /*-----veiculos-----*/
            'veiculos' => 'present|array',

            'veiculos.*.placa' => 'required|string',
            'veiculos.*.modelo' => 'required|string',
            'veiculos.*.cor' => 'required|string',

            
            /*-----convidados-----*/
            'convidados' => 'present|array',

            'convidados.*.nomeConvidado' => 'required|string',
            'convidados.*.cpf' => 'required|string',
            'convidados.*.crianca' => 'present|nullable',
            'convidados.*.celular' => 'present|nullable|string',
            'convidados.*.observacoes' => 'string|present|nullable'
        ];
    }

}
