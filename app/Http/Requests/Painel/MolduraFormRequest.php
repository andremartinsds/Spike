<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class MolduraFormRequest extends FormRequest
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
            'tipo'=>"required",
            'descricao'=>'required'
    ];
    }

    public function messages()
    {
        return [
            'tipo.required'=>'Tipo da moldura é requirido',
            'descricao.required'=>'Descrição da moldura é requirido',
        ];
    }
}
