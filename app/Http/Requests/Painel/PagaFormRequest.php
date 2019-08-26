<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class PagaFormRequest extends FormRequest
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
            'name'=>'required|min:3|max:100',
            'cpf'=>'required|min:11|max:15',
            'rg'=>'min:3|max:50',
            'phone'=>'required',
            'phone_dois'=>'required',
            'endereco'=>'required|min:10|max:100',
            'obs'=>'min:0|max:1000',
        ];
    }
}
