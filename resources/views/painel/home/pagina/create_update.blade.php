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
                Gerenciamento de Páginas
            </h1>
        </div>
    </div>

    <div class="container-fluid">
            
        @if(isset($paginaRecuperada))
            <form method="POST" id="myForm" class="form-vertical  js-form-loading" action="{{route('pagina.atualizar', $paginaRecuperada->id)}}" enctype="multipart/form-data">
        @else
            <form method="post" id="myForm" action="{{route('pagina.salvar')}}" enctype="multipart/form-data" class="form-vertical js-form-loading">
               
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
                    <label for="input-produto-descricao">Categorias para página</label>  
                    <select name="categoria_id" class="form-control">
                        @if(isset($paginaRecuperada))
                            @foreach ($categorias as $categoria)
                                @if($paginaRecuperada->categoria['nome'] == $categoria->nome)
                                    <option selected value="{{$paginaRecuperada->categoria['id']}}">{{$paginaRecuperada->categoria['nome']}}</option>
                                @else
                                    <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                @endif   
                            @endforeach
                        @else
                            @foreach ($categorias as $categoria)
                                <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                            @endforeach
                        @endif
                    </select>           
                    
            </div>
            <div class="form-group">
                <label for="input-produto-nome">Nome da Pagina</label>
                <input type="text" class="form-control" name="nome" id="nome"
                value="{{ isset($paginaRecuperada->nome) ? $paginaRecuperada->nome : old('nome') }}"/>
            </div>
            <br>
            <br>
            <div class="form-group">
                <button id="salvar" class="btn btn-primary" type="submit">Salvar</button>
            <a href="{{route('pagina.index')}}" class="btn  btn-default">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection
