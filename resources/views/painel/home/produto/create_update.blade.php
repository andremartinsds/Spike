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
                Gerenciamento de Produtos
            </h1>
        </div>
    </div>

    <div class="container-fluid">
            
        @if(isset($produtoRecuperado))
            <form method="post" id="myForm" class="form-vertical  js-form-loading" action="{{route('produto.atualizar', $produtoRecuperado->id)}}" enctype="multipart/form-data">
        @else
            <form method="post" id="myForm" action="{{route('produto.salvar')}}" enctype="multipart/form-data" class="form-vertical js-form-loading">
               
        @endif    
            {{ csrf_field() }}
            @if(isset($errors) && count($errors) > 0)
            <div class="alert  alert-success  alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    @foreach($errors->all() as $error)
                        <span aria-hidden="true">&times;</span><i class="fa  fa-check"></i> {{$error}} <br/>
                    @endforeach
            </div>
            @endif

            <div class="form-group">
                    <label for="input-produto-descricao">Escolha a Pagina para exibir esse Produto (Categoria/Pagina)</label>  
                    <select name="pagina_id" id="pagina_id" class="form-control">
                        @if(isset($produtoRecuperado))
                        @foreach($paginas as $pag)
                            @if($produtoRecuperado->pagina['nome'] == $pag->nome)
                                <option selected value="{{$produtoRecuperado->pagina['id']}}">{{$pag->categoria['nome']}} / {{$produtoRecuperado->pagina['nome']}}</option>
                            @else
                                <option value="{{$pag->id}}">{{$pag->categoria['nome']}} / {{$pag->nome}}</option>
                            @endif   
                        @endforeach    
                        @else 
                            @foreach($paginas as $pagina)
                                <option value="{{$pagina->id}}">{{$pagina->categoria['nome']}} / {{$pagina->nome}}</option>
                            @endforeach    
                        @endif
                    </select>           
            </div>

            <div class="form-group">
                <label for="input-produto-nome">Nome do Produto</label>
                <input type="text" class="form-control" name="nome" id="nome" maxlength="50"
                value="{{ isset($produtoRecuperado->nome) ? $produtoRecuperado->nome : old('nome') }}"/>
            </div>
            <div class="form-group">
                    <label for="input-produto-descricao">Descrição completa do produto</label>
                    <textarea class="text-area form-control" id="summernote" rows="3" name="descricao">{{ isset($produtoRecuperado->descricao) ? $produtoRecuperado->descricao: old('descricao') }}</textarea>
            </div>
            
            @if(isset($produtoRecuperado))
            <label for="input-produto-descricao">Molduras já cadastradas</label>
            <div class="form-group">
            @foreach ($molduras as $moldura)
            @if ($loop->first)
                @foreach ($produtoRecuperado->molduraProduto as $mol)
                @if($mol->tipo == $moldura->tipo)
                    <label>
                        <input  class="form-control" type="checkbox" name="moldura_id[]" value="{{$mol->id}}" checked>
                        {{$mol->tipo}}
                    </label>
                @else
                    <label>
                        <input  class="form-control" type="checkbox" name="moldura_id[]" value="{{$mol->id}}" checked>
                        {{$mol->tipo}}
                    </label>
                @endif
                @endforeach
            @endif
                
            @endforeach
            </div>
            @endif
            @if(isset($produtoRecuperado))
            <label for="input-produto-descricao">Todas as molduras</label>
            <div class="form-group">
            @foreach ($molduras as $moldura)
                    <label>
                        <input  class="form-control" type="checkbox" name="moldura_id[]" value="{{$moldura->id}}">
                        {{$moldura->tipo}}
                    </label>
            @endforeach
            </div>
            @endif

            @if(!isset($produtoRecuperado))
            <label for="input-produto-descricao">Molduras</label>
            <div class="form-group">
            @foreach ($molduras as $moldura)
                    <label>
                        <input  class="form-control" type="checkbox" name="moldura_id[]" value="{{$moldura->id}}">
                        {{$moldura->tipo}}
                    </label>
            @endforeach
            </div>
            @endif

            <div class="form-group">
                    <label for="input-produto-nome">Valor Unitário</label>
                    <div class="input-group">
                    <div class="input-group-addon">$</div>
                    <input type="text" data-mask="0000" class="form-control" name="preco" step="any" placeholder="APENAS NÚMEROS, a plataforma não aceita valores quebrados"
                    value="{{ isset($produtoRecuperado->preco) ? $produtoRecuperado->preco : old('preco') }}"/>
                    <div class="input-group-addon">,00</div>
                    </div>
            </div>
             
            <div class="form-group">
                    <label for="input-produto-descricao">Formato Embalagem</label>  
                    <select name="formato_embalagem" id="formato_embalagem" class="form-control">
                        <option value="01">Caixa</option>
                        {{-- <option value="02">Tubo</option>
                        <option value="03">Envelope</option> --}}
                    </select>           
            </div>
            
            <div class="form-group">
                    <label for="input-produto-nome">Peso</label>
                    <div class="input-group">
                    <div class="input-group-addon">P</div>
                    <input type="number" data-mask="00" class="form-control" name="peso" id="peso" step="any" placeholder="APENAS NÚMEROS"
                    value="{{ isset($produtoRecuperado->peso) ? $produtoRecuperado->peso : old('peso') }}"/>
                    <div class="input-group-addon">KL</div>
                </div>
            </div>

            <div class="form-group">
                <label for="input-produto-nome">Mostrar Tamanho(mesmo tamanho cadastrado para o frete)</label>
                <div class="input-group">
                   
                    @if(isset($produtoRecuperado->id_mostra))
                        @if($produtoRecuperado->id_mostra == 1)
                            <input type="radio" name="id_mostra" value="1" checked/> SIM <br>
                            <input type="radio" name="id_mostra" value="2"/> <strong>NÃO</strong> <br>
                        @endif
                    @endif

                   
                    @if(isset($produtoRecuperado->id_mostra))
                        @if($produtoRecuperado->id_mostra == 2)
                            <input type="radio" name="id_mostra" value="1"/> <strong>SIM</strong> <br>
                            <input type="radio" name="id_mostra" value="2" checked/> <strong>NÃO</strong> <br>
                        @endif
                    @endif    

                    @if(!isset($produtoRecuperado->id_mostra)) 
                        <input type="radio" name="id_mostra" value="1"/><strong>SIM</strong> <br>
                        <input type="radio" name="id_mostra" value="2"/> <strong>NÃO</strong> <br>
                    @endif

                </div>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Largura em CM</label>
                    <div class="input-group">
                    <div class="input-group-addon"><--></div>
                    <input type="text" class="form-control" name="largura" id="largura" step="any" placeholder="APENAS NÚMEROS"
                    value="{{ isset($produtoRecuperado->largura) ? $produtoRecuperado->largura : old('largura') }}"/>
                    <div class="input-group-addon">Horizontal</div>
                </div>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Altura</label>
                    <div class="input-group">
                    <div class="input-group-addon">|</div>
                    <input type="text" class="form-control" name="comprimento" id="comprimento" step="any" placeholder="APENAS NÚMEROS"
                    value="{{ isset($produtoRecuperado->comprimento) ? $produtoRecuperado->comprimento : old('comprimento') }}"/>
                    <div class="input-group-addon">Vertical</div>
                    </div>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Expessura</label>
                    <div class="input-group">
                    <div class="input-group-addon">==</div>
                    <input type="text" class="form-control" name="altura" id="altura" step="any" placeholder="APENAS NÚMEROS"
                    value="{{ isset($produtoRecuperado->altura) ? $produtoRecuperado->altura : old('altura') }}"/>
                    <div class="input-group-addon">Expessura</div>
                    </div>
            </div>

            <div class="form-group">
                    <label for="input-produto-nome">Diâmetro em CM</label>
                    <div class="input-group">
                    <div class="input-group-addon">O</div>
                    <input type="text" class="form-control" name="diametro" id="diametro" step="any" placeholder="APENAS NÚMEROS"
                    value="{{ isset($produtoRecuperado->diametro) ? $produtoRecuperado->diametro : old('diametro') }}"/>
                    <div class="input-group-addon">Diâmetro</div>
                    </div>
            </div>

            <div class="form-group">
                    <label for="input-produto-descricao">Imagens do Produto</label>
                    <input type="file" id="file" name="filename[]" multiple>
            </div>
            @if(isset($produtoRecuperado))
            <label for="input-produto-nome">Caso não faça upload de novas imagens, essas imagens permanecerão</label><br>
            @foreach ($produtoRecuperado->imagemProdutos as $image)
                <img src="{{'\\assets\\uploads\\produtos_galeria\\'.$image->nome}}" width="100" alt="">
            @endforeach

            @endif
            
            <br>
            <br>
            <div class="form-group">
                <button id="salvar" class="btn btn-primary" type="submit">Salvar</button>
            <a href="{{route('produto.index')}}" class="btn  btn-default">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection
