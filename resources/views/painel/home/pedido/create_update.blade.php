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
                Código do Pedido {{$pedidoRecuperado->id}}
            </h1>
        </div>
    </div>

    <div class="container-fluid">
            
       

        <div class="table-responsive">
            <table id="tabela-produtos" class="table  table-striped  table-bordered  table-hover  table-condensed  js-sticky-table">
                <thead class="aw-table-header-solid">
                    <tr>
                        <th class="table-pesq-produto-col-preco"># CÓDIGO DO PRODUTO</th>
                        <th class="table-pesq-produto-col-preco">NOME</th>
                        <th class="table-pesq-produto-col-estoque">VALOR UN</th>
                        <th class="table-pesq-produto-col-estoque">MEDIDA EM CM</th>
                        <th class="table-pesq-produto-col-estoque" title="NUmero CEP NO ATO DA COMPRA">Número CEP Calc Pedido</th>
                        <th class="table-pesq-produto-col-estoque">Moldura ou acabamento</th>
                        <th class="table-pesq-produto-col-estoque">IMAGEM</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidoRecuperado->produtos as $produto)
                    <tr>
                        <td class="table-pesq-produto-col-acoes">{{$produto->id}}</td>
                        <td class="table-pesq-produto-col-acoes"><strong>{{$produto->nome}}</strong> </td>
                        <td class="table-pesq-produto-col-acoes"><strong>{!! number_format($produto->preco, 2, ',', '.') !!} </strong></td>
                        <td class="table-pesq-produto-col-acoes"><strong>{{$produto->comprimento}} X {{$produto->largura}} </strong></td>
                        <td class="table-pesq-produto-col-acoes"><strong>{{$pedidoRecuperado->numero_cep_ato_da_compra}} </strong></td>
                        <td class="table-pesq-produto-col-acoes"><strong>{{$produto->produtoDetalheMoldura['moldura']}} </strong></td>
                        <td class="table-pesq-produto-col-acoes"><img src="{{'\\assets\\uploads\\produtos_galeria\\'.$produto->imagemProdutos->first()->nome}}" width="100px"></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <h1>Valor total do Pedido com frete: {!! number_format($pedidoRecuperado->subtotal, 2, ',', '.') !!}</h1>
        </div>
        <form method="POST" id="myForm" class="form-vertical  js-form-loading" action="{{route('pedido.atualizar.fase.pedido', $pedidoRecuperado->id)}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="well form-group">
                <div>
                    @if(isset($pedidoRecuperado->fases))
                    @if($pedidoRecuperado->fases != "[]")
                        <strong><h3>Marque as fases do pedido após a conclusão de cada</h3></strong><br>
                        @foreach ($pedidoRecuperado->fases as $fase)
                            <strong>{{$fase->fase}}</strong><br>
                        @endforeach
                    
                        @foreach ($pedidoRecuperado->fases as $fase)
                                    @if($fase->fase == "PAGO")
                                        @break
                                    @else
                                    @if($loop->last)
                                        <input  type="checkbox" name="fase_pedido" value="1"> <label for="input-produto-nome">Pago</label>
                                    @endif
                                    @endif
                        @endforeach

                        @foreach ($pedidoRecuperado->fases as $fase)
                                    @if($fase->fase == "PRÉ-IMPRESSÃO")
                                        @break
                                    @else
                                    @if($loop->last)
                                        <input  type="checkbox" name="fase_pedido" value="2"> <label for="input-produto-nome">Pré-impressão</label>
                                    @endif
                                    @endif
                        @endforeach
                    
                    @foreach ($pedidoRecuperado->fases as $fase)
                                @if($fase->fase == "PRODUÇÃO")
                                    @break
                                @else
                                @if($loop->last)
                                    <input  type="checkbox" name="fase_pedido"  value="3"> <label for="input-produto-nome">Produção</label>
                                @endif
                                @endif
                    @endforeach       

                    @foreach ($pedidoRecuperado->fases as $fase)
                                @if($fase->fase == "EXPEDIÇÃO")
                                    @break
                                @else
                                    @if($loop->last)
                                        <input  type="checkbox" name="fase_pedido"  value="4"> <label for="input-produto-nome">Expedição</label>
                                    @endif
                                @endif
                    @endforeach 

                    @foreach ($pedidoRecuperado->fases as $fase)
                                @if($fase->fase == "CONCLUÍDO")    
                                    @break
                                @else
                                    @if($loop->last)
                                        <input type="checkbox" name="fase_pedido"  value="5"> <label for="input-produto-nome">Concluido</label>
                                    @endif
                                @endif
                    @endforeach 

                    @foreach ($pedidoRecuperado->fases as $fase)
                                @if($fase->fase == "ENVIADO")    
                                    @break
                                @else
                                    @if($loop->last)
                                        <input type="checkbox" name="fase_pedido"  value="6"> <label for="input-produto-nome">Enviado</label>
                                    @endif
                                @endif   
                    @endforeach             
                        <button class="btn btn-success" type="submit">Atualizar</button>
                    </form>
                        @else 
                        <form method="POST" id="myForm" class="form-vertical  js-form-loading" action="{{route('pedido.atualizar.fase.pedido', $pedidoRecuperado->id)}}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input  type="checkbox" name="fase_pedido" value="1"> <label for="input-produto-nome">Pago</label>
                                <input  type="checkbox" name="fase_pedido" value="2"> <label for="input-produto-nome">Pré-impressão</label>
                                <input  type="checkbox" name="fase_pedido"  value="3"> <label for="input-produto-nome">Produção</label>
                                <input  type="checkbox" name="fase_pedido"  value="4"> <label for="input-produto-nome">Expedição</label>
                                <input type="checkbox" name="fase_pedido"  value="5"> <label for="input-produto-nome">Concluido</label>
                                <input type="checkbox" name="fase_pedido"  value="6"> <label for="input-produto-nome">Enviado</label>
                                <button class="btn btn-success" type="submit">Atualizar</button>
                        </form>        
                        @endif
                    @endif

                </div>
            </div>
       

        <div class="well">
            <strong><h3>Dados do comprador deste(s) produto(s)</h3></strong><br>
            <strong>Nome: </strong> {{$pedidoRecuperado->cliente->nome}} <br>
            <strong>CPF: </strong> {{$pedidoRecuperado->cliente->cpf}} <br>
            <strong>E-mail: </strong> {{$pedidoRecuperado->cliente->email}} <br>
            @if(isset($pedidoRecuperado->cliente->telefone))
                <strong>Telefone :</strong> {{$pedidoRecuperado->cliente->telefone}} <br>
            @endif    
                <strong>CEP: </strong>{{$pedidoRecuperado->cliente->cep}}<br>
                <strong>Endereço: </strong>{{$pedidoRecuperado->cliente->endereco}}<br>
                <strong>Numero: </strong>{{$pedidoRecuperado->cliente->numero}}<br>
            @if(isset($pedidoRecuperado->cliente->complemento))
                <strong>Complemento: </strong> {{$pedidoRecuperado->cliente->complemento}} <br>
            @endif
            <strong>Nome da Cidade: </strong>{{$pedidoRecuperado->cliente->cidade}}<br>
        </div>
    </div>
</section>
@endsection
