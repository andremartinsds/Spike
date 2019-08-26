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
                        Gerenciamento de Categorias
                    </h1>
                </div>

                <div class="col-xs-2">
                    <div class="aw-page-header-controls">
                        <a class="btn btn-primary" href="{{route('categoria.criar')}}">
                            <i class="fa  fa-plus-circle"></i> <span class="hidden-xs  hidden-sm">Nova Categoria</span>
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

        <form action="{{route('categoria.pesquisa')}}" class="form-vertical  js-form-loading">
            <div class="form-group">
                <label for="input-produto-nome">Pesquisar por nome</label>
                <input name="inserido_pelo_usuario" type="text" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn  btn-primary" type="submit">
                    Pesquisar
                </button>
            </div>

        </form>


        <div class="table-responsive">
            <table id="tabela-produtos" class="table  table-striped  table-bordered  table-hover  table-condensed  js-sticky-table">
                <thead class="aw-table-header-solid">
                    <tr>
                        <th class="table-pesq-produto-col-preco">Nome</th>
                        <th class="table-pesq-produto-col-estoque">Status</th>
                        <th class="table-pesq-produto-col-estoque">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                    <tr>
                        <td class="table-pesq-produto-col-acoes">{{$categoria->nome}}</td>
                        <td class="table-pesq-produto-col-acoes">
                            @if($categoria->publicado == 1)
                                Publicado
                            @else
                                Rascunho
                            @endif
                        </td>
                        
                        <td class="table-pesq-produto-col-acoes">
                                <a href="{{route('categoria.editar', $categoria->id)}}">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                </a>
                                | 
                                    <a 
                                    href="{{route('categoria.deletar', $categoria->id)}}"
                                        onclick="return confirm('Esta ação irá excluir a Categoria! {{$categoria->nome}}');"
                                    >
                                                <i class="fa  fa-trash"></i> 
                                </a>
                            </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-xs-12  col-md-8  aw-text-xs-center  aw-text-md-left">

            @if(isset($dadosDoFormularioInseridoPorUsuario))
                {{$categorias->appends($dadosDoFormularioInseridoPorUsuario)->links()}}
            @else
                {{$categorias->links()}}
            @endif
            </div>
        </div>
    </div>

</section>


@endsection
