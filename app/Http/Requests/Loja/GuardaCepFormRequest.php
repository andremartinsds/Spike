<?php

namespace App\Http\Requests\Loja;

use Illuminate\Foundation\Http\FormRequest;

class GuardaCepFormRequest extends FormRequest
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
            'numero'=>"required",
            'id'=>"required",
    ];
    }

    public function messages()
    {
        return [
            'numero.required' => 'CEP requerido',
            'id.required' => 'Não há produto selecionado para cacular o frete',
        ];
    }
}
