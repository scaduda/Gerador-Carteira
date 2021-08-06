<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class StoreRgbmRequest extends FormRequest
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
            'nom_completo' => 'required|string|max:255',
            'cargo_nome' => 'required|max:100|string',
            'num_cpf' => 'required|string',
            'num_matricula' => 'required',
            'dat_validade_rgbm' => 'required|string',
            'tip_sangue' => 'required|string|max:4',
            'num_rgbm' => 'required',
            'rg' => 'required',
            'dat_nasc' => 'required|string',
            'siape' => 'required|string',
            'naturalidade' => 'required|string',
            'nacionalidade' =>'required|string',
        ];
    }

    public function messages()
    {
        return [];
    }

    /**
     * Retorna os erros encontrados
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
