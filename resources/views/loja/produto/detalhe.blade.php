@extends('loja.layouts.main')

@section('content')
<br>
<div class="container">
    <div class="row">
        <div class="col-sm-5">
            <section>
                        <div class="cycle-slideshow"
                             data-cycle-fx=scrollHorz
                             data-cycle-timeout=4000
                             data-cycle-pager="#adv-custom-pager"
                             data-cycle-pager-template="<a href='#'><img src='@{{src}}' width=80 height=80></a>"
                             >

                            @if(count($produto->imagemProdutos))
                                @foreach($produto->imagemProdutos as $image)
                                    <img src="{{'\\assets\\uploads\\produtos_galeria\\'.$image->nome}}" width="450" alt="">
                                @endforeach
                                </div>
                                <br>
                                <div class="padding10">
                                    <div id=adv-custom-pager class="center external"></div>
                                </div>
                                <br>
                            @else
                                <img src="#" width="200" alt="sem imagem cadastrada"/>
                            @endif
                        
                        <!-- empty element for pager links -->
                            <!--jQuery-->

            </section>
            <p>{!! $produto->descricao !!}</p>
        </div>


        <div class="col-sm-7">
            <div class="product-information"><!--/product-information-->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </ul>
                    </div>
                @endif
                <span style="color: #123456;font-size: 2.1em;font-weight: bold;"><h2>{{$produto->nome}}</h2></span>
            @if($produto->id_mostra == 1)
                <span style="color: #123456;font-size: 1.2em;font-weight: bold;"><p>Tamanho: {{$produto->largura}}cm X {{$produto->comprimento}}cm</p></span>
            @else 
                <span style="color: #123456;font-size: 1.2em;font-weight: bold;"><p>Tamanho e Quantidade: Na descrição</p></span>
            @endif
            <form action="{{route('add.cart.detalhes', $produto->id)}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                @if((!$produto->molduraProduto->isEmpty()))
                <div class="select">
                    <select name="moldura_id">
                        <option disabled selected>Selecione uma moldura</option>
                        @foreach ($produto->molduraProduto as $moldura)
                            <option value="{{$moldura->id}}">{{$moldura->tipo}}</option>
                        @endforeach
                    </select> 
                </div>
            @endif

            <span style="color: #123456;font-size: 2.1em;font-weight: bold;">R$ {{number_format($produto->preco, 2, ',', '.')}}</span>
            <span style="color: #d80000;font-size: 1.2em;font-weight: bold;"> até 12x de R$ {{number_format($produto->preco / 12, 2, ',', '.')}} sem juros</span> <br>
                <button class="botao-add-cart" type="submit">COMPRAR</button>
            </form>

                {{-- <form action="{{route('cep.detalhe', $produto->id)}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <label>Calcular frete</label><br>
                    <input name="numero" />
                    <button type="submit">Calcular Frete</button>
                </form> --}}
    
                @if(isset($frete))
                <div class="form-group">
                    <label>Data de entrega aproximada caso o pagamento seja compensado hoje. O cálculo não considera os feriados.</label>
                    <label>Pac</label>
                    <label> {{number_format($frete[0]['valor'], 2, ',', '.')}} e {{$frete[0]['prazo']}} Dias para entrega</label><br>
                    <label>Sedex</label>
                   <label> {{number_format($frete[1]['valor'], 2, ',', '.')}} e {{$frete[1]['prazo']}} Dias para entrega</label>
                </div>

            </div>
    </form>
    @endif

            <br>
        </div>
    </div>
</div>

@endsection