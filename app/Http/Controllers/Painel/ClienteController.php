<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Categoria;
use App\Cliente;
use App\Estado;
use App\Http\Requests\Painel\ClientePainelFormRequest;

class ClienteController extends Controller
{
    private $clientes;
    private $totalPaginas = 10;
    public function __construct(Cliente $clientes)
    {
        $this->clientes = $clientes;
        $this->middleware('auth');
    }
    public function index()
    {
        $clientes = $this->clientes->paginate($this->totalPaginas);
        return view('painel.home.cliente.index', compact("clientes"));
    }

    public function criar()
    {
        $estados = Estado::all();
        return view('painel.home.cliente.create_update', compact("estados"));
    }

    public function salvar(ClientePainelFormRequest $request)
    {
        $dadosDoFormulario = $request->all();

        $dadosDoFormulario['user_id'] = auth()->user()->id;

        $clienteSalvo = $this->clientes->create($dadosDoFormulario);

        if ($clienteSalvo) {
            return redirect()->route('cliente.index');
        } else {
            return view('painel.home.cliente.index')
                ->withErrors(['errors' => 'Erro ao cadastrar'])
                ->with(['errors']);
        }
    }

    public function deletar($id)
    {
        $clienteRecuperado = $this->clientes->find($id);
        $clienteRecuperado->delete();
        return redirect()->route('cliente.index');
    }

    public function editar($id)
    {
        $estados = Estado::all();
        $clienteRecuperado = $this->clientes->find($id);
        return view('painel.home.cliente.create_update', compact("clienteRecuperado", "estados"));
    }

    public function atualizar($id, ClientePainelFormRequest $request)
    {

        $dadosDoFormulario = $request->all();
        $dadosDoFormulario['user_id'] = auth()->user()->id;

        $clienteSelecionado = $this->clientes->find($id);

        $atualizarDadosCategoria = $clienteSelecionado->update($dadosDoFormulario);

        if ($atualizarDadosCategoria) {

            return redirect()->route('cliente.index');
        } else {
            return redirect()->route('cliente.create_update', ['id' => $id])
                ->withErrors(['errors' => 'Algo inesperado, aconteceu. ERRO'])
                ->withInput();
        }

    }

    public function pesquisa(ClientePainelFormRequest $request)
    {
        $dadosDoFormularioInseridoPorUsuario = $request->except('_token');
        
        if(!isset($dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario'])) {
            $clientes = $this->clientes->paginate($this->totalPaginas);
            return view('painel.home.cliente.index', compact("clientes", "dadosDoFormularioInseridoPorUsuario"));
        }
        $clientes = $this->clientes->where('nome', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario']}%")
            ->paginate($this->totalPaginas);
        return view('painel.home.cliente.index', compact("clientes", "dadosDoFormularioInseridoPorUsuario"));

    }
}
