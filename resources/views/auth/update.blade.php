@extends('painel.layouts.app')
@section('menu')
@parent
@endsection
@section('content')
<section class="aw-layout-content  js-content">


    <div class="page-header">
        <div class="container-fluid">
            <h1>
                Cadastro de pessoa
            </h1>
        </div>
    </div>

    <div class="container-fluid">
        <form method="POST" action="{{ route('atualizar.usuario', $user->id) }}" class="form-vertical js-form-loading">
            {{ csrf_field() }}

            @if(isset($errors) && count($errors) > 0)
            <div class="alert  alert-success  alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    @foreach($errors->all() as $error)
                        {{$error}} <br/>
                    @endforeach
            </div>
            @endif
            <div class="form-group">
                <label for="input-produto-nome">Nome</label>

                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                    value="{{ isset($user->name) ? $user->name : old('name') }}" required autofocus>

                @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="input-produto-nome">Endereço de E-mail</label>

                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                    name="email" value="{{ isset($user->email) ? $user->email : old('email') }}" required>

                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="input-produto-nome">Senha</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    name="password" required>
                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="input-produto-nome">Confirme a Senha</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <button id="salvar" class="btn btn-primary" type="submit">Salvar</button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('footer')
@parent
@endsection