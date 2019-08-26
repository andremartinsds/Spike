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
        <form method="POST" action="{{ route('deletar.usuario', $user->id) }}" class="form-vertical js-form-loading">
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
                <p>{{$user->name}}</p>
            </div>

            <div class="form-group">
                <label for="input-produto-nome">Nome</label>
                <p>{{$user->email}}</p>
            </div>

            <div class="form-group">
                <button id="salvar" class="btn btn-primary" type="submit">Deletar</button>
                <a href="{{route('usuarios.todos')}}" id="salvar" class="btn btn-primary" type="button">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection
@section('footer')
@parent
@endsection