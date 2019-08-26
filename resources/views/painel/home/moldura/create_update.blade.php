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
                Gerenciamento de molduras
            </h1>
        </div>
    </div>

    <div class="container-fluid">
            
        @if(isset($molduraRecuperada))
            <form method="POST" id="myForm" class="form-vertical  js-form-loading" action="{{route('moldura.atualizar', $molduraRecuperada->id)}}" enctype="multipart/form-data">
        @else
            <form method="post" id="myForm" action="{{route('moldura.salvar')}}" enctype="multipart/form-data" class="form-vertical js-form-loading">
               
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
                <label for="input-produto-nome">Tipo da Moldura</label>
                <input type="text" class="form-control" name="tipo" id="tipo"
                value="{{ isset($molduraRecuperada->tipo) ? $molduraRecuperada->tipo : old('tipo') }}"/>
            </div>

            <div class="form-group">
                <label for="input-produto-nome">Descrição</label>
                <input type="text" class="form-control" name="descricao" id="descricao"
                value="{{ isset($molduraRecuperada->descricao) ? $molduraRecuperada->descricao : old('descricao') }}"/>
            </div>

            
            <br>
            <br>
            <div class="form-group">
                <button id="salvar" class="btn btn-primary" type="submit">Salvar</button>
            <a href="{{route('moldura.index')}}" class="btn  btn-default">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection
