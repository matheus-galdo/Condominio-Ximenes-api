<?php

namespace App\Http\Requests\Ocorrencias;

use Illuminate\Foundation\Http\FormRequest;

class CreateOcorrenciaFollowupRequest extends FormRequest
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
            'descricao' => 'required|string',
            'evento' => 'required|exists:App\Models\Ocorrencia\EventoFollowup,id',
            'ocorrencia' => 'required|exists:App\Models\Ocorrencia\Ocorrencia,id',

            'arquivos' => 'sometimes|array',
            'arquivos.*' => 'required|file|mimetypes:application/pdf',
        ];
    }
}
