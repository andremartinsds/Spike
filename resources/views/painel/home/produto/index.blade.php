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
                        Gerenciamento de Produtos
                    </h1>
                </div>

                <div class="col-xs-2">
                    <div class="aw-page-header-controls">
                        <a class="btn btn-primary" href="{{route('produto.criar')}}">
                            <i class="fa  fa-plus-circle"></i> <span class="hidden-xs  hidden-sm">Novo Produto </span>
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

        <form action="{{route('produto.pesquisa')}}" class="form-vertical  js-form-loading">
            <div class="form-group">
                <label for="input-produto-nome">Pesquisar</label>
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
                        <th class="table-pesq-produto-col-preco">Codigo</th>
                        <th class="table-pesq-produto-col-estoque">Criação / Edição / Autor</th>
                        <th class="table-pesq-produto-col-preco">Imagem</th>
                        <th class="table-pesq-produto-col-preco">Nome</th>
                        <th class="table-pesq-produto-col-estoque">Preco</th>
                        <th class="table-pesq-produto-col-estoque">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                    <tr>
                        <td class="table-pesq-produto-col-acoes">{{$produto->id}}</td>
                        <td class="table-pesq-produto-col-acoes">Criação: {{date('d/m/Y',strtotime($produto->created_at))}} Edição: {{date('d/m/Y',strtotime($produto->updated_at))}} <br>
                            Altor do Produto: {{$produto->user->name}}</td>
                        <td class="table-pesq-produto-col-acoes">
                            <img src="{{'\\assets\\uploads\\produtos_galeria\\'.$produto->imagemProdutos->first()['nome']}}" width="50" alt="">
                        </td>
                        <td class="table-pesq-produto-col-acoes">{{$produto->nome}}</td>
                        <td class="table-pesq-produto-col-acoes">{{number_format($produto->preco, 2, ',', '.')}}</td>
                        
                        <td class="table-pesq-produto-col-acoes">
                                <a href="{{route('produto.editar', $produto->id)}}">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                </a>
                                | 
                                    <a 
                                    href="{{route('produto.deletar', $produto->id)}}"
                                        onclick="return confirm('Esta ação irá excluir o produto! {{$produto->nome}}');"
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
                {{$produtos->appends($dadosDoFormularioInseridoPorUsuario)->links()}}
            @else
                {{$produtos->links()}}
            @endif
            </div>
        </div>
    </div>

</section>


@endsection
