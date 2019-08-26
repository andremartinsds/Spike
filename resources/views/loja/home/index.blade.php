@extends('loja.layouts.main')

@section('header')
@parent
@endsection

@section('webbanner')
@parent
@endsection

@section('content')
<section class="products">
    <h1 class="title">NOSSOS PRODUTOS</h1>
    <div class="row">
    @forelse($produtos as $produto)
    
    @php
        $nome = explode(" ", $produto->nome);
        $tracoNoNome = implode("-", $nome);
        @endphp
        <article class="col-sm-12 col-md-3 col-lg-3">
            <a href="{{route('produto.detalhes',[$tracoNoNome, $produto->id])}}">
                <div class="borda-dez-radial">
                    <img class="img-responsive" src="{{'\\assets\\uploads\\produtos_galeria\\'.$produto->imagemProdutos->first()->nome}}">
                </div>
            </a>
            <div class="text-center">
                <p style="font-size: 14px;

                margin-top: 8px;

                margin-bottom: -22px;

                line-height: 18px;
                
                word-wrap: break-word;
                
                word-break: break-word;
                
                font-weight: bold;
                
                color: #ce1f24;">{{$produto->nome}}</p>
                <h3 style="text-transform: capitalize;

                color: #123456;
                margin-bottom: -8px;
                font-size: 2.3em;
                
                font-weight: bold;
                
                letter-spacing: -2px;">R$ {{number_format($produto->preco, 2, ',', '.')}}</h3>
            </div>
            
            <a href="{{route('produto.detalhes',[$tracoNoNome, $produto->id])}}">
                <button class="botao-cart">
                    + Detalhes
                </button></a>

        </article>
        @if(!isset($indice))
        <input type="hidden" value="{{$indice=0}}">
        @endif
        <input type="hidden" value="{{$indice = $indice + 1}}">
        @if(4 == $indice)
        @if($indice == 4)
        <input type="hidden" value="{{$indice = 0}}">
        @endif
        
        </div>
        <div class="row">

        @endif
      

    @empty
    <p>Não existem produtos cadastrados!</p>
    @endforelse
</div>
</section>
<!--Products-->
@endsection