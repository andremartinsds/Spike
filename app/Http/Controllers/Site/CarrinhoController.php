<?php

namespace App\Http\Controllers\Site;

use App\Carrinho;
use App\Categoria;
use App\Pedido;
use App\Produto;
use Correios;
use Illuminate\Http\Request;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\SDK;
use Session;
use App\Http\Requests\Loja\DetalhesCarrinhoFormRequest;
use App\MolduraProduto;
use App\ProdutoDetalheMoldura;
use App\Http\Requests\Loja\GuardaCepFormRequest;

class CarrinhoController extends Controller
{
    public $carrinho, $produtos, $categorias, $pedido;

    public function __construct(Carrinho $carrinho, Produto $produtos, Categoria $categorias, Pedido $pedido)
    {
        $this->carrinho = $carrinho;
        $this->produtos = $produtos;
        $this->categorias = $categorias;
        $this->pedido = $pedido;
    }

    public function carrinho()
    {
        $categorias = $this->categorias->all();

        $carrinho = new Carrinho;

        $produtos = $carrinho->getItems();
        if (Session::has('frete')) {
            $frete = Session::get('frete');
            return view('loja.cart.cart', compact('carrinho', 'produtos', 'categorias', 'frete'));
        }
        return view('loja.cart.cart', compact('carrinho', 'produtos', 'categorias'));

    }

    public function addCartDetalhes($id, DetalhesCarrinhoFormRequest $request)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return redirect()->back();
        }
        if($request->moldura_id > 0 && $produto->molduraProduto->isEmpty() == false) {
            $moldura = MolduraProduto::find($request->moldura_id);
            Session::put('moldura', $moldura->tipo);
            $produtoDetalhe = new ProdutoDetalheMoldura;
            $produtoDetalhe->id_produto = $produto->id;
            $produtoDetalhe->moldura = Session::get("moldura");
            $produtoDetalhe->save();
            $carrinho = new Carrinho;
            $carrinho->add($produto);
            Session::put('carrinho', $carrinho);
            if (null != $carrinho->getItems() && Session::has('frete')) {
                $this->calculoFrete();
            }
        }
        else if($request->moldura_id == null && $produto->molduraProduto->isEmpty() == true) {
            $carrinho = new Carrinho;
            $carrinho->add($produto);
            Session::put('carrinho', $carrinho);
            if (null != $carrinho->getItems() && Session::has('frete')) {
                $this->calculoFrete();
            }
        }
        else {
            return redirect()->back()->withErrors(["errors"=>"Selecione o tipo de moldura"]);
        }
        return redirect()->route('carrinho');
    }

    
    public function add($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return redirect()->back();
        }

        $carrinho = new Carrinho;
        $carrinho->add($produto);
        Session::put('carrinho', $carrinho);
        if (null != $carrinho->getItems() && Session::has('frete')) {
            $this->calculoFrete();
        }

        return redirect()->route('carrinho');
    }
    public function remove($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return redirect()->back();
        }

        $carrinho = new Carrinho;
        $carrinho->remove($produto);

        Session::put('carrinho', $carrinho);

        if ($carrinho->getItems() == []) {
            Session::forget("frete");
        }
        if (Session::has('frete')) {
            $this->calculoFrete();
        }
        return redirect()->route('carrinho');
    }

    public function statusPagamento(Request $request)
    {
        if (null == Session::get('cliente')) {
            return redirect()->route('cliente.index.login');
        }
        $carrinho = new Carrinho;

        $token = $request->input("token");
        $payment_method_id = $request->input("payment_method_id");
        $installments = $request->input("installments");
        $issuer_id = $request->input("issuer_id");

        SDK::setAccessToken("TEST-4204154549090018-120419-11eea9a916e8c125910164bbab9e48bb-30303367");
        $payment = new Payment();
        $payment->transaction_amount = Session::get('sub_total');
        $payment->token = $token;

        $cliente = Session::get('cliente');
        if(is_array($cliente)) {
            foreach($cliente as $key=>$cli) {
                $cliente = $cli;
            }
        }
        $payment->description = $cliente->nome;
        $payment->installments = $installments;
        $payment->payment_method_id = $payment_method_id;
        $payment->issuer_id = $issuer_id;
        $payment->payer = array(
            "email" => $cliente->email,
        );

        $payment->save();

        if ($payment->status == 'approved') {
            $pedido = new Pedido;
            $pedido['tipo_frete'] = Session::get('tipo_frete');
            $pedido['tipo_pagamento'] = $payment_method_id;
            $pedido['id_cliente'] = $cliente->id;
            $pedido['valor_frete'] = Session::get('valor_frete');
            $pedido['subtotal'] = Session::get('sub_total');
            $pedido['numero_cep_ato_da_compra'] = Session::get('numerocep');
            $carrinho = Session::get('carrinho');
       
            $pedido->save();
            $items = $carrinho->getItems();

            foreach ($items as $key => $item) {
                $qtdProduto = $carrinho->getItems()[$key]['qtd'];

                for ($j = 1; $j <= $qtdProduto; $j++) {
                    $idProduto = $carrinho->getItems()[$key]['item']['id'];
                    $pedido->produtos()->attach($idProduto);
                }
            }
            Session::forget('carrinho');
            return redirect()->route('cliente.pedidos');
        } else {
            $pedido = new Pedido;
            $pedido['tipo_frete'] = Session::get('tipo_frete');
            $pedido['tipo_pagamento'] = "Pagamento não aprovado, você pode fazer uma transferência";
            $pedido['id_cliente'] = $cliente->id;
            $pedido['valor_frete'] = Session::get('valor_frete');
            $pedido['subtotal'] = Session::get('sub_total');
            $pedido['numero_cep_ato_da_compra'] = Session::get('numerocep');
            $carrinho = Session::get('carrinho');

            $pedido->save();
            $items = $carrinho->getItems();

            foreach ($items as $key => $item) {
                $qtdProduto = $carrinho->getItems()[$key]['qtd'];

                for ($j = 1; $j <= $qtdProduto; $j++) {
                    $idProduto = $carrinho->getItems()[$key]['item']['id'];
                    $pedido->produtos()->attach($idProduto);
                }
            }
            Session::forget('carrinho');
            return redirect()->route('cliente.pedidos');
        }

    }

    public function pagamentoTransferencia(Request $request)
    {
        if (null == Session::get('cliente')) {
            return redirect()->route('cliente.index.login');
        }
        $carrinho = new Carrinho;
        $cliente = Session::get('cliente');
        if(is_array($cliente)) {
            foreach($cliente as $key=>$cli) {
                $cliente = $cli;
            }
        }
    
        $pedido = new Pedido;
        $pedido['tipo_frete'] = Session::get('tipo_frete');
        $pedido['tipo_pagamento'] = "Transferência Bancária";
        $pedido['id_cliente'] = $cliente->id;
        $pedido['valor_frete'] = Session::get('valor_frete');
        $pedido['subtotal'] = Session::get('sub_total');
        $pedido['numero_cep_ato_da_compra'] = Session::get('numerocep');
        $carrinho = Session::get('carrinho');


        $pedido->save();
        $items = $carrinho->getItems();

        foreach ($items as $key => $item) {
            $qtdProduto = $carrinho->getItems()[$key]['qtd'];

            for ($j = 1; $j <= $qtdProduto; $j++) {
                $idProduto = $carrinho->getItems()[$key]['item']['id'];
                $pedido->produtos()->attach($idProduto);
            }
        }
        Session::forget('carrinho');
        return redirect()->route('cliente.pedidos');

    }

    public function guardaCep(Request $request)
    {
        Session::put('numerocep', $request->numero);
        return $this->calculoFrete();
    }

    public function calculoFrete()
    {
        $carrinho = new Carrinho;
        $larguraTotal = $carrinho->larguraTotal();
        $alturaTotal = $carrinho->alturaTotal();
        $comprimentoTotal = $carrinho->comprimentoTotal();
        
        $soma = $carrinho->larguraTotal() + $carrinho->alturaTotal() + $carrinho->comprimentoTotal();
        if($soma > 200) {
            $larguraTotal = $carrinho->larguraTotal();
            $larguraTotal = 66;

            $alturaTotal = $carrinho->alturaTotal();
            $alturaTotal = 66;

            $comprimentoTotal = $carrinho->comprimentoTotal();
            $comprimentoTotal = 66;
        }

        $dados = [
            'tipo' => 'pac,sedex', // Separar opções por vírgula (,) caso queira consultar mais de um (1) serviço. > Opções: `sedex`, `sedex_a_cobrar`, `sedex_10`, `sedex_hoje`, `pac`, 'pac_contrato', 'sedex_contrato' , 'esedex'
            'formato' => 'caixa', // opções: `caixa`, `rolo`, `envelope`
            'cep_destino' => Session::get('numerocep'), // Obrigatório
            'cep_origem' => '77015012', // Obrigatorio
            //'empresa'         => '', // Código da empresa junto aos correios, não obrigatório.
            //'senha'           => '', // Senha da empresa junto aos correios, não obrigatório.
            'peso' => $carrinho->pesoTotal(), // Peso em kilos
            'comprimento' => $comprimentoTotal, // Em centímetros
            'altura' => $alturaTotal, // Em centímetros
            'largura' => $larguraTotal, // Em centímetros
            'diametro' => $carrinho->diametroTotal(), // Em centímetros, no caso de rolo
            // 'mao_propria'       => '1', // Não obrigatórios
            // 'valor_declarado'   => '1', // Não obrigatórios
            // 'aviso_recebimento' => '1', // Não obrigatórios
        ];

        $valorItemFretes = Correios::frete($dados);
        if($valorItemFretes[0]['erro']['codigo'] == -3.0 || $valorItemFretes[1]['erro']['codigo'] == -3.0) {
            $invalido = "CEP INVÁLIDO";
            $categorias = $this->categorias->all();
            $carrinho = new Carrinho;
            $produtos = $carrinho->getItems();
            if(null !== Session::get('frete')) {
                Session::forget('frete');
            }
            return view('loja.cart.cart', compact('invalido', 'carrinho', 'produtos', 'categorias'));
            
        } else {
            Session::put('frete', $valorItemFretes);
            $frete = Session::get('frete');
            $categorias = $this->categorias->all();
            $carrinho = new Carrinho;
            $produtos = $carrinho->getItems();
            return view('loja.cart.cart', compact('frete', 'carrinho', 'produtos', 'categorias'));
        }
    }


    public function subtotalcart(Request $request)
    {
        $carrinho = new Carrinho;
        $frete = Session::get("frete");
        if ($request->input("tipo_frete") == 1) {
            $tipoDeFrete = "PAC";
            Session::put('tipo_frete', $tipoDeFrete);
            $valorDoFrete = $frete[0]["valor"];
            Session::put('valor_frete', $valorDoFrete);
            $subtotal = ($frete[0]["valor"] + $carrinho->total());
            Session::put('sub_total', $subtotal);
            $radio = 1;
        }
        if ($request->input("tipo_frete") == 2) {
            $tipoDeFrete = "SEDEX";
            Session::put('tipo_frete', $tipoDeFrete);
            $valorDoFrete = $frete[1]["valor"];
            Session::put('valor_frete', $valorDoFrete);
            $subtotal = ($frete[1]["valor"] + $carrinho->total());
            Session::put('sub_total', $subtotal);
            $radio = 2;
        } else {
            $tipoDeFrete = "PAC";
            Session::put('tipo_frete', $tipoDeFrete);
            $valorDoFrete = $frete[0]["valor"];
            Session::put('valor_frete', $valorDoFrete);
            $subtotal = ($frete[0]["valor"] + $carrinho->total());
            Session::put('sub_total', $subtotal);
            $radio = 1;
        }
        $produtos = $carrinho->getItems();
        $categorias = $this->categorias->all();
        return view('loja.cart.cart', compact('radio', 'subtotal', 'frete', 'carrinho', 'produtos', 'categorias'));
    }

}
