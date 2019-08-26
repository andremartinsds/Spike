@extends('loja.layouts.main')

@section('content')
<h3>Seus dados são importantes para enviarmos sua mercadoria com segurança</h3>

<div class="container-fluid">
    <form method="POST" action="{{ route('cliente.save') }}" class="form-vertical js-form-loading" enctype="multipart/form-data">
        {{ csrf_field() }}

        @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </ul>
                    </div>
        @endif
        <div class="form-inline">
            <div class="form-group">
                <input id="nome" type="text" class="form-control" name="nome" required autofocus placeholder="Nome*" value="{{old('nome')}}">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" required placeholder="E-mail*" value="{{old('email')}}">
            </div>
           
        <div class="form-group">
            <input type="text" class="cpf form-control" name="cpf" required autofocus placeholder="CPF*" value="{{old('cpf')}}">
        </div>

        <div class="form-group">
            <input type="text" class="phone_with_ddd form-control" name="telefone" autofocus placeholder="Telefone" value="{{old('telefone')}}">
        </div>

        <div class="form-group">
            <input id="senha" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="senha" required  placeholder="Senha*" value="{{old('senha')}}">
        </div>
        <div class="form-group">
            <input type="text" class="cep form-control" name="cep" required autofocus placeholder="CEP*" value="{{old('cep')}}">
        </div>
        <div class="form-group">
            <input id="endereco" type="text" class="form-control" name="endereco" required autofocus placeholder="Endereço*" value="{{old('endereco')}}">
        </div>
        <div class="form-group">
            <input id="numero" type="text" class="form-control" name="numero" autofocus placeholder="Número" value="{{old('numero')}}">
        </div>
        
        <div class="form-group">
            <input id="complemento" type="text" class="form-control" name="complemento" autofocus placeholder="Complemento" value="{{old('complemento')}}">
        </div>
        <div class="form-group">
            <input id="bairro" type="text" class="form-control" name="bairro" autofocus placeholder="Bairro" value="{{old('bairro')}}">
        </div>
        <div class="form-group">
            <input id="cidade" type="text" class="form-control" name="cidade" required autofocus placeholder="Cidade*" value="{{old('cidade')}}">
        </div>
        <div class="form-group">
            <select name="id_estado" id="id_estado" class="form-control control-label" required placeholder="Estado*" >
                <option value="">Estado</option>
                    @foreach($estados as $estado)
                        <option value="{{$estado->id}}">{{ $estado->nome }}</option>
                    @endforeach
            </select>
        </div>
        <div class="form-group">
            <button id="salvar" class="btn btn-primary" type="submit">Salvar</button>
        </div>
        </div>

    </form>
</div>

@endsection