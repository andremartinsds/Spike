<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\MolduraProduto;
use App\Http\Requests\Painel\MolduraFormRequest;

class MolduraController extends Controller
{
    private $molduras;
    private $totalPaginas = 10;
    public function __construct(MolduraProduto $molduras)
    {
        $this->molduras = $molduras;
        $this->middleware('auth');
    }

    public function index()
    {
        $molduras = $this->molduras->paginate($this->totalPaginas);
        return view('painel.home.moldura.index', compact("molduras"));
    }

    public function criar()
    {
        return view('painel.home.moldura.create_update');
    }

    public function salvar(MolduraFormRequest $request)
    {
        $dadosDoFormulario = $request->all();

        $dadosDoFormulario['user_id'] = auth()->user()->id;

        $molduraSalva = $this->molduras->create($dadosDoFormulario);

        if ($molduraSalva) {
            return redirect()->route('moldura.index');
        } else {
            return view('painel.home.categoria.index')
                ->withErrors(['errors' => 'Erro ao cadastrar'])
                ->with(['errors']);
        }
    }

    public function deletar($id)
    {
        $molduraRecuperada = $this->molduras->find($id);
        $molduraRecuperada->delete();
        return redirect()->route('moldura.index');
    }

    public function editar($id)
    {
        $molduraRecuperada = $this->molduras->find($id);
        return view('painel.home.moldura.create_update', compact("molduraRecuperada"));
    }

    public function atualizar($id, MolduraFormRequest $request)
    {

        $dadosDoFormulario = $request->all();
        $dadosDoFormulario['user_id'] = auth()->user()->id;

        $molduraSelecinada = $this->molduras->find($id);

        $atualizarDadosMoldura = $molduraSelecinada->update($dadosDoFormulario);

        if ($atualizarDadosMoldura) {

            return redirect()->route('moldura.index');
        } else {
            return redirect()->route('moldura.create_update', ['id' => $id])
                ->withErrors(['errors' => 'Algo inesperado, aconteceu. ERRO'])
                ->withInput();
        }

    }

    public function pesquisa(MolduraFormRequest $request)
    {
        $dadosDoFormularioInseridoPorUsuario = $request->except('_token');
        
        if(!isset($dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario'])) {
            $molduras = $this->molduras->paginate($this->totalPaginas);
            return view('painel.home.moldura.index', compact("molduras", "dadosDoFormularioInseridoPorUsuario"));
        }
        $molduras = $this->molduras->where('tipo', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario']}%")
            ->paginate($this->totalPaginas);
        return view('painel.home.moldura.index', compact("molduras", "dadosDoFormularioInseridoPorUsuario"));

    }
}
