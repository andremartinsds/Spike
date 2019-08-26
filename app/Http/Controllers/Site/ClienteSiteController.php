<?php

namespace App\Http\Controllers\Site;

use App\Categoria;
use App\Cliente;
use App\Estado;
use App\Pedido;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\Painel\ClienteFormRequest;
use Session;
use Symfony\Component\Routing\Route;
use App\PedidoComprovante;

class ClienteSiteController extends Controller
{
    private $cliente;
    private $request;
    private $totalPaginas = 10;
    private $categorias;
    private $estados;
    private $pedidos;

    public function __construct(Cliente $cliente, Categoria $categorias, Estado $estados, Pedido $pedidos)
    {
        $this->cliente = $cliente;
        $this->categorias = $categorias;
        $this->estados = $estados;
        $this->pedidos = $pedidos;
    }

    public function indexCadastro()
    {
        $cliente = Session::get('cliente');
        $idCLiente = $cliente[0]['id'];
        if (null !== (Session::get('cliente'))) {
            $categorias = Categoria::all();
            $cliente = Cliente::find($idCLiente);
            $pedidos = Pedido::where('id_cliente', '=', $idCLiente)->get();
            return view('loja.cliente.cliente', compact('cliente', 'pedidos', 'categorias'));

        } else {
            return $this->login();
        }
    }
    public function indexLogin()
    {
        $cliente = Session::get('cliente');
        
        // $idCLiente = $cliente[0]['id'];
        if (null !== (Session::get('cliente'))) {
            $categorias = Categoria::all();
            $cliente = Cliente::find($cliente->id);
            $pedidos = Pedido::where('id_cliente', '=', $cliente->id)->get();
            return view('loja.cliente.cliente', compact('cliente', 'pedidos', 'categorias'));
        } else {
            return $this->login();
        }
    }

    public function pedidos()
    {
        
        $cliente = Session::get('cliente');
        if(is_array($cliente)) {
            foreach($cliente as $key=>$cli) {
                $cliente = $cli;
            }
        }
        $categorias = Categoria::all();
        $cliente = Cliente::find($cliente->id);
        $pedidos = Pedido::where('id_cliente', '=', $cliente->id)->orderBy('id','desc')->get();
        return view('loja.cliente.cliente', compact('cliente', 'pedidos', 'categorias'));
    }

    public function login()
    {
        $categorias = Categoria::all();
       
        if (null == (Session::get('cliente'))) {
            return view('loja.cliente.login', compact('categorias'));
        } else {
            $cliente = Session::get('cliente');
            if ($cliente[0]["id"] == '') {
                $idCLiente = $cliente->id;
                $cliente = Cliente::find($idCLiente);
                $pedidos = Pedido::where('id_cliente', '=', $idCLiente)->orderBy('id','desc')->get();
                return view('loja.cliente.cliente', compact('categorias', 'cliente', 'pedidos'));
            } else {
                $idCLiente = $cliente[0]['id'];
                $cliente = Cliente::find($idCLiente);
                $pedidos = Pedido::where('id_cliente', '=', $idCLiente)->orderBy('id','desc')->get();
                return view('loja.cliente.cliente', compact('categorias', 'cliente', 'pedidos'));
            }

        }
    }

    public function autoriza(Request $request)
    {
        $dadosDoFormulario = $request->all();
        $clienteRecuperado = Cliente::where('email', '=', $dadosDoFormulario['email'])->get();
        if (isset($clienteRecuperado[0]) && $clienteRecuperado[0] != '' && $clienteRecuperado[0] != null) {
            $clienteRecuperado = $clienteRecuperado[0];
            if ($dadosDoFormulario['email'] == $clienteRecuperado->email &&
                $dadosDoFormulario['senha'] == $clienteRecuperado->senha) {
                Session::put('cliente', $clienteRecuperado);
                return redirect()->route('cliente.index.login');
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function register()
    {
        $categorias = Categoria::all();
        $estados = Estado::all();
        return view('loja.cliente.create', compact("categorias", "estados"));
    }

    public function save(ClienteFormRequest $request)
    {
        $idClenteInserido = DB::table('clientes')->insertGetId(
            array(
                'nome' => $request->input('nome'),
                'cpf' => $request->input('cpf'),
                'endereco' => $request->input('endereco'),
                'telefone' => $request->input('telefone'),
                'email' => $request->input('email'),
                'senha' => $request->input('senha'),
                'cep' => $request->input('cep'),
                'numero' => $request->input('numero'),
                'complemento' => $request->input('complemento'),
                'bairro' => $request->input('bairro'),
                'cidade' => $request->input('cidade'),
                'id_estado' => $request->input('id_estado'),
            )
        );
        if(Session::has('cliente')) {
            Session::forget('cliente');
        } else {
            $cliente = [$this->cliente->find($idClenteInserido)];
            Session::put('cliente', $cliente);
        }

        if (isset($cliente)) {
            return redirect()->route('carrinho');
        } else {
            return redirect()
                ->route('cliente.criar')
                ->withErrors('errors')
                ->withInput();
        }
    }

    public function clienteLogout()
    {
        Session::forget('cliente');
        return redirect()->route('site.home');
    }

    public function salvar($id, Request $request)
    {
        $dadosDoFormulario = $request->all();
        $pedidoSalvo = $this->pedidos->find($id);
        if (isset($dadosDoFormulario['comprovante'])) {
            $recuperaImagemDoFormulario = $request->file('comprovante');
            $imagemComprovante = new PedidoComprovante;
            
            $renomeiaImagemParaSalvar = uniqid(date('YmdHis')) . '.' . $recuperaImagemDoFormulario->getClientOriginalExtension();
            $uploadDaImagemDoUsuario = $recuperaImagemDoFormulario->storeAs('comprovantes', $renomeiaImagemParaSalvar);
            
            $imagemComprovante->pedido_id = $pedidoSalvo->id;
            $imagemComprovante->comprovante = $renomeiaImagemParaSalvar;

            $imagemComprovante->save();
        }
        if ($imagemComprovante) {
            return redirect()->route('cliente.pedidos');
        } else {
            return view('produto.erro')
                ->withErrors(['errors' => 'Erro ao cadastrar'])
                ->with(['errors']);
        }
    }

}
