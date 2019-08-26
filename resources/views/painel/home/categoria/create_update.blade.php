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
                Gerenciamento de Projetos
            </h1>
        </div>
    </div>

    <div class="container-fluid">
            
        @if(isset($categoriaRecuperada))
            <form method="POST" id="myForm" class="form-vertical  js-form-loading" action="{{route('categoria.atualizar', $categoriaRecuperada->id)}}" enctype="multipart/form-data">
        @else
            <form method="post" id="myForm" action="{{route('categoria.salvar')}}" enctype="multipart/form-data" class="form-vertical js-form-loading">
               
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
                <label for="input-produto-nome">Nome da Categoria</label>
                <input type="text" class="form-control" name="nome" id="nome"
                value="{{ isset($categoriaRecuperada->nome) ? $categoriaRecuperada->nome : old('titulo') }}"/>
            </div>

            <div class="form-group">
                    <label for="input-produto-descricao">Publicar ou Salvar em Rascunho</label>  
                    <select name="publicado" id="publicado" class="form-control">
                        @if(isset($categoriaRecuperada->publicado) && $categoriaRecuperada->publicado == "1")
                            <option value="1">Publicado</option>
                            <option value="0">Rascunho</option>
                        @elseif(isset($categoriaRecuperada->publicado) && $categoriaRecuperada->publicado == "0")
                            <option value="0">Rascunho</option>
                            <option value="1">Publicado</option>
                        @endif
                            @if(!isset($categoriaRecuperada->publicado))
                                <option value="1">Publicado</option>
                                <option value="0">Rascunho</option>
                            @endif

                    </select>           
                    
            </div>
            <br>
            <br>
            <div class="form-group">
                <button id="salvar" class="btn btn-primary" type="submit">Salvar</button>
            <a href="{{route('categoria.index')}}" class="btn  btn-default">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection
