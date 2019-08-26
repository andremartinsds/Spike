<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Categoria;
use App\Http\Requests\Painel\CategoriaFormRequest;
use Mail;

class CategoriaController extends Controller
{
    private $categorias;
    private $totalPaginas = 10;
    public function __construct(Categoria $categorias)
    {
        $this->categorias = $categorias;
        $this->middleware('auth');
    }

    public function mandaEmail() 
    {
        Mail::raw('This is an test e-mail', function ($message) {
            $message->to("andremartinsdsilva@gmail.com", "someone");
            $message->subject("hi checking");
            $message->getSwiftMessage();
        });
    }

    public function index()
    {
        $categorias = $this->categorias->paginate($this->totalPaginas);
        return view('painel.home.categoria.index', compact("categorias"));
    }

    public function criar()
    {
        return view('painel.home.categoria.create_update');
    }

    public function salvar(CategoriaFormRequest $request)
    {
        $dadosDoFormulario = $request->all();

        $dadosDoFormulario['user_id'] = auth()->user()->id;

        $prjetoSalvo = $this->categorias->create($dadosDoFormulario);

        if ($prjetoSalvo) {
            return redirect()->route('categoria.index');
        } else {
            return view('painel.home.categoria.index')
                ->withErrors(['errors' => 'Erro ao cadastrar'])
                ->with(['errors']);
        }
    }

    public function deletar($id)
    {
        $categoriaRecuperada = $this->categorias->find($id);
        $categoriaRecuperada->delete();
        return redirect()->route('categoria.index');
    }

    public function editar($id)
    {
        $categoriaRecuperada = $this->categorias->find($id);
        return view('painel.home.categoria.create_update', compact("categoriaRecuperada"));
    }

    public function atualizar($id, CategoriaFormRequest $request)
    {

        $dadosDoFormulario = $request->all();
        $dadosDoFormulario['user_id'] = auth()->user()->id;

        $categoriaSelecinada = $this->categorias->find($id);

        $atualizarDadosCategoria = $categoriaSelecinada->update($dadosDoFormulario);

        if ($atualizarDadosCategoria) {

            return redirect()->route('categoria.index');
        } else {
            return redirect()->route('categoria.create_update', ['id' => $id])
                ->withErrors(['errors' => 'Algo inesperado, aconteceu. ERRO'])
                ->withInput();
        }

    }

    public function pesquisa(CategoriaFormRequest $request)
    {
        $dadosDoFormularioInseridoPorUsuario = $request->except('_token');
        
        if(!isset($dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario'])) {
            $categorias = $this->categorias->paginate($this->totalPaginas);
            return view('painel.home.categoria.index', compact("categorias", "dadosDoFormularioInseridoPorUsuario"));
        }
        $categorias = $this->categorias->where('nome', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario']}%")
            ->paginate($this->totalPaginas);
        return view('painel.home.categoria.index', compact("categorias", "dadosDoFormularioInseridoPorUsuario"));

    }
}
