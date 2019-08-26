@extends('painel.layouts.app')

@section('menu')
@parent
@endsection

@section('content')
<section class="aw-layout-content  js-content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-10">
                    <h1>
                        Usuários Cadastrados
                    </h1>
                </div>

                <div class="col-xs-2">
                    <div class="aw-page-header-controls">
                        <a class="btn btn-primary" href="{{route('register')}}">
                            <i class="fa  fa-plus-circle"></i> <span class="hidden-xs  hidden-sm">Novo Usuário</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        @if(isset($errors) && count($errors) > 0)
        <div class="alert  alert-success  alert-dismissible" role="alert">
            <div class="container-fluid alert-danger">
                @foreach($errors->all() as $error)
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa  fa-check"></i>
                <p>{{$error}}</p>
                @endforeach
            </div>
        </div>
        @endif

        <div class="table-responsive">
            <table id="tabela-produtos" class="table  table-striped  table-bordered  table-hover  table-condensed  js-sticky-table">
                <thead class="aw-table-header-solid">
                    <tr>
                        <th class="table-pesq-produto-col-preco">Nome</th>
                        <th class="table-pesq-produto-col-estoque">Endereço de Email</th>
                        <th class="table-pesq-produto-col-status">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{$usuario->name}}</td>
                        <td>{{$usuario->email}}</td>

                        <td class="table-pesq-produto-col-acoes">
                            Sem ações
                            <a href="{{route('editar.usuario', $usuario->id)}}">
                                <button class="btn  btn-default btn-xs">
                                    <i class="fa  fa-pencil"></i>
                                </button>
                            </a>
                            <a href="{{route('seleciona.delete.usuario', $usuario->id)}}"> 
                                <i class="fa  fa-trash"></i> 
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

</section>


@endsection
