@extends('painel.layouts.app')
<div class="spinner-wrapper" style="display:none">
	<div class="spinner"></div>
</div>
@section('menu')
@parent
@endsection

@section('content')

<section class="aw-layout-content  js-content">


    <div class="page-header">
        <div class="container-fluid">
            <h1>
                Cadastro de Web Banner
            </h1>
        </div>
    </div>

    <div class="container-fluid">
            
        @if(isset($webbannerRecuperado))
            <form method="POST" id="myForm" class="form-vertical  js-form-loading" action="{{route('webbanner.atualizar', $webbannerRecuperado->id)}}" enctype="multipart/form-data">
        @else
            <form method="post" id="myForm" action="{{route('webbanner.salvar')}}" enctype="multipart/form-data" class="form-vertical js-form-loading">
        @endif    
            {{ csrf_field() }}
            @if(isset($errors) && count($errors) > 0)
            <div class="alert  alert-success  alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    @foreach($errors->all() as $error)
                        <span aria-hidden="true">&times;</span><i class="fa  fa-check"></i> {{$error}} <br/>
                    @endforeach
            </div>
            @endif

            <div class="form-group">
                <label for="input-produto-nome">Titulo do web banner</label>
                <input type="text" class="form-control" name="title" id="title" 
                value="{{ isset($webbannerRecuperado->title) ? $webbannerRecuperado->title : old('title') }}"/>
            </div>

            <div class="form-group">
                <label for="input-produto-nome">Url (Apenas para redirecionamento externo - ex: https://www.google.com)</label>
                <input type="text" class="form-control" name="url" id="url" 
                value="{{ isset($webbannerRecuperado->url) ? $webbannerRecuperado->url : old('url') }}"/>
            </div>
            
            <div class="form-group">
                    <label for="input-produto-descricao">Publicar ou Salvar em Rascunho</label>  
                    <select name="publicado" id="publicado" class="form-control">
                        @if(isset($webbannerRecuperado->publicado) && $webbannerRecuperado->publicado == "1")
                            <option value="1">Publicado</option>
                            <option value="0">Rascunho</option>
                        @elseif(isset($webbannerRecuperado->publicado) && $webbannerRecuperado->publicado == "0")
                            <option value="0">Rascunho</option>
                            <option value="1">Publicado</option>
                        @endif
                            @if(!isset($webbannerRecuperado->publicado))
                                <option value="1">Publicado</option>
                                <option value="0">Rascunho</option>
                            @endif

                    </select>           
                    
            </div>
            
            <div class="form-group">
                    <label for="input-produto-nome">Arquivo de Imagem Apenas arquivos PNG ou JPG (Dimensão 940x380px tamanho máximo supoertado 2mb)</label>
                    <input type="file" class="form-control" name="imagem"/>
            </div>
            @if(isset($webbannerRecuperado->imagem))
                <div class="form-group">
                        <label for="input-produto-nome">Caso não coloque uma nova imagem permanecerá a imagem abaixo: </label> <br/>
                    <img src="{{'\\assets\\uploads\\webbanners\\'.$webbannerRecuperado->imagem}}" width="260" height="104">
                </div>
            @endif

            <div class="form-group">
                <button id="salvar" class="btn btn-primary" type="submit">Salvar</button>
            <a href="{{route('webbanners')}}" class="btn  btn-default">Cancelar</a>
            </div>
        </form>
    </div>
</section>



@endsection
