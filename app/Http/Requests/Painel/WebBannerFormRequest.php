<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class WebBannerFormRequest extends FormRequest
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
            'title'=>'min:3|max:100',
            'url'=>"min:3|max:600|unique:web_banners,url, {$this->segment(2)} ,id",
            'imagem' => 'mimes:jpg,jpeg,png',

    ];
    }

    public function messages()
    {
        return [
            'titulo.min' => '(TITULO) Mínimo de caractéres não foi atingido',
            'titulo.max' => '(TITULO) máximo de caractéres foi atingido',
            'url.min'  => '(URL) Mínimo de 3 caractéres e máximo de 600',
            'imagem.required'  => '(IMAGEM) obrigatória',
            'imagem.mimes'  => '(IMAGEM) obrigatória',
        ];
    }
}
