<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class ClienteFormRequest extends FormRequest
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
            'nome'=>'required|max:100',
            'email'=>'email|required',
            'cpf'=>'required|max:15',
            'telefone'=>'required',
            'senha'=>'required',
            'cep'=>'required',
            'endereco'=>'required|max:200',
            'cidade'=>'required',
            'id_estado'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => '(Nome) ENTADA OBRIGATÓRIA PARA CADASTRO ',
            'email.required' => '(Email) ENTADA OBRIGATÓRIA PARA CADASTRO ',
            'cpf.required'  => '(CPF) ENTADA OBRIGATÓRIA PARA CADASTRO ',
            'telefone.required'  => '(Telefone) ENTADA OBRIGATÓRIA PARA CADASTRO',
            'cep.required'  => '(CEP) ENTADA OBRIGATÓRIA PARA CADASTRO ',
            'endereco.required'  => '(Endereco) ENTADA OBRIGATÓRIA PARA CADASTRO ',
            'cidade.required'  => '(cidade) ENTADA OBRIGATÓRIA PARA CADASTRO ',
            'id_estado.required'  => '(Estado) ENTADA OBRIGATÓRIA PARA CADASTRO',
        ];
    }
}
