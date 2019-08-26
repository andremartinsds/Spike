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
                Gerenciamento de Cliente
            </h1>
        </div>
    </div>

    <div class="container-fluid">
            
        @if(isset($clienteRecuperado))
            <form method="POST" id="myForm" class="form-vertical  js-form-loading" action="{{route('cliente.atualizar', $clienteRecuperado->id)}}" enctype="multipart/form-data">
        @else
            <form method="post" id="myForm" action="{{route('cliente.salvar')}}" enctype="multipart/form-data" class="form-vertical js-form-loading">
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
                <label for="input-produto-nome">Nome do Cliente</label>
                <input type="text" class="form-control" name="nome" id="nome"
                value="{{ isset($clienteRecuperado->nome) ? $clienteRecuperado->nome : old('nome') }}"/>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Email do Cliente</label>
                    <input type="email" class="form-control" name="email" id="nome"
                    value="{{ isset($clienteRecuperado->email) ? $clienteRecuperado->email : old('email') }}"/>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">CPF do Cliente</label>
                    <input type="text" class="form-control" name="cpf" id="nome"
                    value="{{ isset($clienteRecuperado->cpf) ? $clienteRecuperado->cpf : old('cpf') }}"/>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Telefone do Cliente</label>
                    <input type="text" class="form-control" name="telefone" id="telefone"
                    value="{{ isset($clienteRecuperado->telefone) ? $clienteRecuperado->telefone : old('telefone') }}"/>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Senha</label>
                    <input type="password" class="form-control" name="senha" id="senha"
                    value="{{ isset($clienteRecuperado->senha) ? $clienteRecuperado->senha : old('senha') }}"/>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">CEP</label>
                    <input type="text" class="form-control" name="cep" id="cep"
                    value="{{ isset($clienteRecuperado->cep) ? $clienteRecuperado->cep : old('cep') }}"/>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Endereço</label>
                    <input type="text" class="form-control" name="endereco" id="endereco"
                    value="{{ isset($clienteRecuperado->endereco) ? $clienteRecuperado->endereco : old('endereco') }}"/>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Número</label>
                    <input type="number" class="form-control" name="numero" id="numero"
                    value="{{ isset($clienteRecuperado->numero) ? $clienteRecuperado->numero : old('numero') }}"/>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Complemento</label>
                    <input type="text" class="form-control" name="complemento" id="complemento"
                    value="{{ isset($clienteRecuperado->complemento) ? $clienteRecuperado->complemento : old('complemento') }}"/>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Bairro</label>
                    <input type="text" class="form-control" name="bairro" id="bairro"
                    value="{{ isset($clienteRecuperado->bairro) ? $clienteRecuperado->bairro : old('bairro') }}"/>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Cidade</label>
                    <input type="text" class="form-control" name="cidade" id="cidade"
                    value="{{ isset($clienteRecuperado->cidade) ? $clienteRecuperado->cidade : old('cidade') }}"/>
            </div>

            <div class="form-group">
                        <label for="input-produto-descricao">Estado</label>  
                        <select name="id_estado" id="id_estado" class="form-control" required>
                            @if(isset($clienteRecuperado))
                            @foreach($estados as $est)
                                @if($clienteRecuperado->estados['nome'] == $est->nome)
                                    <option selected value="{{$clienteRecuperado->estados['id']}}">{{$est->nome}}</option>
                                @else
                                        <option value="{{$est->id}}">{{ $est->nome }}</option>
                                @endif   
                            @endforeach
                            @else 
                                @foreach($estados as $estado)
                                        <option value="{{$estado->id}}">{{ $estado->nome }}</option>
                                @endforeach    
                            @endif
                        </select>           
        </div>
            
            <br>
            <br>
            <div class="form-group">
                <button id="salvar" class="btn btn-primary" type="submit">Salvar</button>
            <a href="{{route('cliente.index')}}" class="btn  btn-default">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection
