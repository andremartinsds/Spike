@extends('loja.layouts.main')

@section('content')
<h1 class="title">Acessar minha conta</h1>

<div class="container-fluid">
    <form method="POST" action="{{ route('cliente.autentica') }}" class="form-vertical js-form-loading" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="input-produto-nome">Endereço de E-mail</label>
            <input id="email" type="email" class="form-control" name="email" required>
        </div>

        <div class="form-group">
            <label for="input-produto-nome">Senha</label>
            <input id="senha" type="password" class="form-control" name="senha" required>
        </div>
        <div class="form-group">
            <button id="salvar" class="btn btn-primary" type="submit">Entrar</button>
            <a href="{{route('cliente.regiter')}}" class="btn btn-danger">Criar conta</a>
        </div>
    </form>
</div>

@endsection