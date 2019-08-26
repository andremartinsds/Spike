@extends('loja.layouts.main')

@section('content')
<br>
<div class="well">
    <strong><p>Dados bancários</p></strong>
    <img src="/images/conta.png" width="600px">
</div>
<h1 class="title">Olá {{$cliente->nome}}</h1>
Meus pedidos: <br>

@foreach ($pedidos as $pedido)
        <div class="meus-pedidos">
        Data e horarario: <strong>{{(new DateTime($pedido->created_at))->format('d/m/Y H:i:s')}}</strong><br>
        Codigo: <strong>{{$pedido->id}}</strong><br>
        Tipo de Pagamento: <strong>{{$pedido->tipo_pagamento}}</strong><br>
        Tipo de Frete: <strong>{{$pedido->tipo_frete}}</strong><br>
        Valor do Frete: <strong>{!! number_format($pedido->valor_frete, 2, ',', '.') !!}</strong><br>
        Valor Total do Pedido: <strong>{!! number_format($pedido->subtotal, 2, ',', '.') !!}</strong><br>
        <br>
        <strong><p>Itens do Pedido</p></strong>

        @foreach ($pedido->produtos->unique() as $produto)
                <strong>Quantidade: {{$loop->iteration}}</strong> <br>
                <strong>Nome do Produto: {{$produto->nome}}</strong> <br>
                <strong>Valor unitário: {!! number_format($produto->preco, 2, ',', '.') !!} </strong><br>
                <strong>Medida em cm: {{$produto->comprimento}} X {{$produto->largura}} </strong><br>
                <img src="{{'\\assets\\uploads\\produtos_galeria\\'.$produto->imagemProdutos->first()->nome}}" class="img-cart">
        @endforeach
        <div class="status-pedido"> 
            Status do seu pedido: <br>
            @if(isset($pedido->fases))
            <input type="hidden" value="{{$acumuladorDeFase = 0}}">
                @foreach ($pedido->fases as $fase)
                    @if($fase->fase == 'PAGO')
                        <input type="hidden" value="{{$acumuladorDeFase = 1}}">
                    @endif    
                    @if($fase->fase == 'PRÉ-IMPRESSÃO')
                        <input type="hidden" value="{{$acumuladorDeFase = 2}}">
                    @endif    
                    @if($fase->fase == 'PRODUÇÃO')
                        <input type="hidden" value="{{$acumuladorDeFase = 3}}">
                    @endif    
                    @if($fase->fase == 'EXPEDIÇÃO')
                        <input type="hidden" value="{{$acumuladorDeFase = 4}}">
                    @endif    
                    @if($fase->fase == 'CONCLUÍDO')
                        <input type="hidden" value="{{$acumuladorDeFase = 5}}">
                    @endif    
                    @if($fase->fase == 'ENVIADO')
                        <input type="hidden" value="{{$acumuladorDeFase = 6}}">
                    @endif
                @endforeach
                    @if(isset($acumuladorDeFase))
                        @if($acumuladorDeFase == 1)
                            <img src="/images/fases/1.png" title="PAGO"></i>
                        @endif

                        @if($acumuladorDeFase == 2)
                            <img src="/images/fases/2.png" title="PRÉ IMPRESSÃO OU CORTE"></i>
                        @endif

                        @if($acumuladorDeFase == 3)
                            <img src="/images/fases/3.png" title="PRODUZIDO"></i>
                        @endif

                        @if($acumuladorDeFase == 4)
                            <img src="/images/fases/4.png" title="CONFERIDO"></i>
                        @endif

                        @if($acumuladorDeFase == 5)
                            <img src="/images/fases/5.png" title="CONCLUÍDO"></i>
                        @endif

                        @if($acumuladorDeFase == 6)
                            <img src="/images/fases/6.png" title="ENVIADO"></i>
                        @endif
                    @endif    
            @endif
            
        </div>
        @if(isset($pedido->comprovante))
        <p>Comprovante de pagamento anexado</p>
            <a href="{{'\\assets\\uploads\\comprovantes\\'.$pedido->comprovante['comprovante']}}" target="_blank">
                Meu comprovante
            </a>
        @else
        <form action="{{route('pedido.comprovante', $pedido->id)}}" enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
            <label>Insira o comprovante de pagamento</label>
            <input type="file" name="comprovante">
            <br>
            <button class="btn btn-primary" type="submit">Enviar comprovante</button>
        </form>
        @endif
    </div>
    @endforeach
<br>
    <a class="btn btn-primary" href="{{route('cliente.logout')}}">Sair</a>

    <br>
    <br>
    <br>
    <br>
    <br>
@endsection