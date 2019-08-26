@extends('loja.layouts.main')

@section('content')
<h1 class="title">Meu Carrinho</h1>

<table class="table table-striped">
    <tr>
        <th>Item</th>
        <th>Preço</th>
        <th>Quantidade</th>
        <th>Sub. Total</th>
    </tr>

    @forelse($produtos as $produto)
    <tr>
        <td>
            <img src="{{'\\assets\\uploads\\produtos_galeria\\'.$produto['item']->imagemProdutos->first()->nome}}" class="img-cart">
            {{$produto['item']->name}}
        </td>
        <td>R$ {{number_format($produto['item']->preco, 2, ',', '.')}}</td>
        <td>
            {{$produto['qtd']}}
            <a href="{{route('add.cart', $produto['item']->id)}}" class="cart-action-item">+</a> -
            <a href="{{route('remove.cart', $produto['item']->id)}}" class="cart-action-item">-</a>
        </td>
        <td>R$ {{number_format($produto['item']->preco * $produto['qtd'], 2, ',', '.')}}</td>
    </tr>
    @empty
    <p>Nenhum item no carrinho!</p>
    @endforelse
</table>

<div class="total-cart">
        
    <span>
        @if(isset($subtotal))
        <p> Subtotal + frete</p>
            R$ {{number_format($subtotal, 2, ',', '.')}}
        @else
        <p> Subtotal</p>
            R$ {{number_format($carrinho->total(), 2, ',', '.')}}
        @endif

    </span>
</div>
<div class="well" style="min-height: 155px;">

<form action="{{route('guardacep.cart')}}" method="POST" class="form-inline" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
                @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    {{ $error }} <br>
                @endforeach
            </ul>
        </div>
    @endif
            <label>Calcular frete</label><br>
            <input class="cep meu-cep-input form-control" name="numero" />
            <button class="button6" type="submit">Calcular</button>
        </div>
</form>
@if(isset($invalido))
    <label> {{$invalido}} </label>
@endif
@if(isset($frete))
    <form action="{{route('subtotalcart.cart')}}" method="POST" name="form1" id="form1">
     {{ csrf_field() }}
    <div class="form-group">
        <strong>Selecine o FRETE para envio</strong> <br>
            @if(isset($radio))
                @if($radio == 1)
                        <label>PAC</label>
                        <input type="radio" id="radio_01" name="tipo_frete" value="1" checked onclick="enviaFormInputCorreio();">
                        <label> 
                            {{number_format($frete[0]['valor'], 2, ',', '.')}} 
                            e
                             {{$frete[0]['prazo']}} Dias para entrega
                            </label><br>
                        <label>SEDEX</label>
                        <input type="radio" id="radio_02" name="tipo_frete" value="2" onclick="enviaFormInputCorreio();"> <label> {{number_format($frete[1]['valor'], 2, ',', '.')}} e {{$frete[1]['prazo']}} Dias para entrega</label>    

                @endif
                @if($radio == 2)
                    <label>PAC</label>
                    <input type="radio" id="radio_01" name="tipo_frete" value="1"  onclick="enviaFormInputCorreio();"> <label> {{number_format($frete[0]['valor'], 2, ',', '.')}} e {{$frete[0]['prazo']}} Dias para entrega</label><br>
                    <label>SEDEX</label>
                    <input type="radio" id="radio_02" name="tipo_frete" value="2" checked onclick="enviaFormInputCorreio();"> <label> {{number_format($frete[1]['valor'], 2, ',', '.')}} e {{$frete[1]['prazo']}} Dias para entrega</label>
                @endif
            @else
                <label>PAC</label>
                <input type="radio" id="radio_01" name="tipo_frete" value="1" onclick="enviaFormInputCorreio();"> <label> {{number_format($frete[0]['valor'], 2, ',', '.')}} e {{$frete[0]['prazo']}} Dias para entrega</label><br>
                <label>SEDEX</label>
                <input type="radio" id="radio_02" name="tipo_frete" value="2" onclick="enviaFormInputCorreio();"> <label> {{number_format($frete[1]['valor'], 2, ',', '.')}} e {{$frete[1]['prazo']}} Dias para entrega</label>
            @endif
            <br>
            <p>Data de entrega aproximada caso o pagamento seja compensado hoje.<br> O cálculo não considera os feriados.</p>
    </div>
    </form> 

<div>
    <div>
    <br>
</div>

<div class="finish-card">
    <P>Opções de pagamento</P>
    <hr>
            @if(null !== (Session::get('cliente')))
            <form action="{{route('paga.tokenizer.mercadopago')}}" method="POST">
                {{ csrf_field() }}
                @if(isset($subtotal))
                <script src="https://www.mercadopago.com.br/integrations/v1/web-tokenize-checkout.js"
                data-public-key="TEST-1c9a8dee-2af5-4a29-a4e4-a97779be8e1e"
                    data-transaction-amount="{{$subtotal}}"
                    data-button-label="Cartão de crédito">
                    
                </script>
                @endif
                @else
                <a href="{{route('cliente.index.login')}}">
                    Entrar
                </a>
                @endif
                
            </form>
            @if(null !== (Session::get('cliente')))
             @if(isset($subtotal))
             <form method="POST" action="{{route('paga.transferencia')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <button type="submit" class="mercadopago-button" title="em breve">Transferência</button>
            </form>   
             @endif   
            @endif    
            @endif
</div>



@endsection

