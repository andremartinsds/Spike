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
                        Gerenciamento de Pedidos
                    </h1>
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

        <form action="{{route('pedido.pesquisa')}}" class="form-vertical  js-form-loading">
            <div class="form-group">
                <label for="input-produto-nome">Pesquisar</label>
                <input name="inserido_pelo_usuario" type="text" class="form-control" placeholder="Pesquisa total da venda">
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
                        <th class="table-pesq-produto-col-preco">Código</th>
                        <th class="table-pesq-produto-col-preco">Data do Pedido</th>
                        <th class="table-pesq-produto-col-preco">Tipo de Frete</th>
                        <th class="table-pesq-produto-col-preco">Valor do Frete</th>
                        <th class="table-pesq-produto-col-estoque">Tipo de Pagamento</th>
                        <th class="table-pesq-produto-col-estoque">Total com frete</th>
                        <th class="table-pesq-produto-col-estoque">Cliente</th>
                        <th class="table-pesq-produto-col-estoque">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                    <tr>
                        <td class="table-pesq-produto-col-acoes">{{$pedido->id}}</td>
                        <td class="table-pesq-produto-col-acoes">{{date('d/m/Y',strtotime($pedido->created_at))}}</td>
                        <td class="table-pesq-produto-col-acoes">{{$pedido->tipo_frete}}</td>
                        <td class="table-pesq-produto-col-acoes">{!! number_format($pedido->valor_frete, 2, ',', '.') !!}</td>
                        <td class="table-pesq-produto-col-acoes">{{$pedido->tipo_pagamento}}</td>
                        <td class="table-pesq-produto-col-acoes">{!! number_format($pedido->subtotal, 2, ',', '.') !!} </td>
                        <td class="table-pesq-produto-col-acoes">{{$pedido->cliente['nome']}}</td>
                        
                        
                        <td class="table-pesq-produto-col-acoes">
                                <a href="{{route('pedido.editar', $pedido->id)}}">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
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
                {{$pedidos->appends($dadosDoFormularioInseridoPorUsuario)->links()}}
            @else
                {{$pedidos->links()}}
            @endif
            </div>
        </div>
    </div>

</section>


@endsection
