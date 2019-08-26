<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Produto;
use App\Pagina;
use App\Categoria;
use App\Carrinho;
use Session;

class LojaController extends Controller
{
    private $categoria, $produto, $pagina;

    public function __construct(Categoria $categoria, Produto $produto, Pagina $pagina)
    {
        $this->categoria = $categoria;
        $this->produto = $produto;
        $this->pagina = $pagina;
    }

    public function index()
    {
        $produtos = $this->produto->orderBy('id', 'DESC')->get();
        $categorias = $this->categoria->all();
        //return view('loja.home.aguardem');
        return view('loja.home.index', compact('produtos', 'categorias'));
    }

    public function pagina($id)
    {   
        $categorias = $this->categoria->all();
        $pagina = $this->pagina->find($id);
        $produtos = Produto::where('pagina_id','=', $pagina->id)->get();
        return view("loja.home.index", compact('produtos', "pagina", "categorias"));
    }
    
    public function detalhesProduto($nome, $id)
    {
        $produto = Produto::find($id);
        $categorias = Categoria::all();
        return view('loja.produto.detalhe', compact('produto','categorias'));
    }

    public function filtro(Request $request)
    {
        $dadosDoFormularioInseridoPorUsuario = $request->except('_token');
        $categorias = $this->categoria->all();
        
        if(!isset($dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario'])) {
            $produtos = $this->produto->get();
            return view('loja.home.index', compact("produtos", "categorias", "dadosDoFormularioInseridoPorUsuario"));
        }
        $produtos = $this->produto->where('nome', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario']}%")
            ->get();
        return view('loja.home.index', compact("produtos", "categorias", "dadosDoFormularioInseridoPorUsuario"));

    }
}
