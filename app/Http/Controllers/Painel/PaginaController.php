<?php 

namespace App\Http\Controllers\Painel;

use App\Http\Requests\Painel\ClienteFormRequest;
use Illuminate\Http\Request;
use App\Pagina;
use App\Categoria;
use App\Http\Requests\Painel\PaginaFormRequest;
use Auth;

class PaginaController extends Controller
{
    private $pagina;
    private $request;
    private $totalPaginas = 10;

    public function __construct(Pagina $pagina)
    {
        $this->pagina = $pagina;
        $this->middleware('auth');
    }

    public function index()
    {
        $categorias = Categoria::all();
        $paginas = $this->pagina->paginate($this->totalPaginas);
        return view('painel.home.pagina.index', compact("paginas", "categorias"));
    }

    public function criar()
    {
        $categorias = Categoria::all();
        return view('painel.home.pagina.create_update', compact('categorias'));
    }

    public function salvar(Pagina $pagina, PaginaFormRequest $request)
    {
        $dadosDoFormulario = $request->all();
        $user_id = Auth::user()->id;
        $dadosDoFormulario['user_id'] = $user_id;

        $salvar = $pagina->create($dadosDoFormulario);

        if ($salvar) {
            return redirect()->route('pagina.index');
        } else {
            return redirect()
                ->route('pagina.criar')
                ->withErrors('errors')
                ->withInput();
        }
    }

    public function vizualizar($id)
    {
        $paginaRecuperada = $this->pagina->find($id);
        return view('painel.home.pagina.show_cliente', compact("paginaRecuperada"));
    }

    public function editar($id)
    {
        $paginaRecuperada = $this->pagina->find($id);
        $categorias = Categoria::all();
        return view('painel.home.pagina.create_update', compact("paginaRecuperada", "categorias"));
    }

    public function atualizar($id, PaginaFormRequest $request)
    {
        $dadosDoFormulario = $request->all();
        $paginaRecuperada = $this->pagina->find($id);
        $user_id = Auth::user()->id;
        $paginaRecuperada["user_id"] = $user_id;
        $atualizarDadosPagina = $paginaRecuperada->update($dadosDoFormulario);

        if ($atualizarDadosPagina) {
            return redirect()->route('pagina.index');
        } else {
            return redirect()->route('pagina.editar', ['id' => $id])
                ->withErrors(['errors' => 'Algo inesperado, aconteceu. ERRO'])
                ->withInput();
        }

    }

    public function deletar($id)
    {
        $paginaRecuperada = $this->pagina->find($id);
        $deletarPagina = $paginaRecuperada->delete();
        if ($deletarPagina) {
            return redirect()->route('pagina.index');
        } else {
            return view('painel.erros.erro_recuperado')
                ->withErrors(['errors' => 'Erro ao tentar deletar o usuario ou sua imagem']);
        }

        return view('painel.erros.erro_desconhecido');
    }

    public function pesquisa(PaginaFormRequest $request)
    {
        $dadosDoFormularioInseridoPorUsuario = $request->except('_token');
        
        if(!isset($dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario'])) {
            $paginas = $this->pagina->paginate($this->totalPaginas);
            return view('painel.home.pagina.index', compact("paginas", "dadosDoFormularioInseridoPorUsuario"));
        }
        $paginas = $this->pagina->where('nome', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario']}%")
            ->paginate($this->totalPaginas);
        return view('painel.home.pagina.index', compact("paginas", "dadosDoFormularioInseridoPorUsuario"));

    }

}
