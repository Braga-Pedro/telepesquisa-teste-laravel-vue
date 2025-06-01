<?php

namespace App\Http\Requests\Empresas;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'cep' => 'required|string|min:7|max:8',
            'rua' => 'required|string|max:255',
            'numero_casa' => 'required|string|max:10',
            'bairro' => 'required|string|max:255',
            'estado' => 'required|string|min:1|max:2',
            'telefone' => 'required|string|min:8|max:15',
            'cpf_cnpj' => [
                'required',
                'string',
                'min:10',
                'max:14',
                'unique:empresas,cpf_cnpj',
                'regex:/^(\d{11}|\d{14})$/'
            ],
            'segmento_id' => 'nullable|integer|exists:segmentos,id',
            'segmento' => 'nullable|string|max:255',
        ];
    }
}
