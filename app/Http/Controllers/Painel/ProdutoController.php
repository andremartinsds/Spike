<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Produto;
use App\Pagina;
use App\Http\Requests\Painel\ProdutoFormRequest;
use App\ImagemProduto;
use App\MolduraProduto;
use File;
use DB;
use App\Mostrar;

class ProdutoController extends Controller
{
    private $produtos;
    private $totalPaginas = 10;
    public function __construct(Produto $produtos)
    {
        $this->produtos = $produtos;
        $this->middleware('auth');
    }

    public function index()
    {
        $produtos = $this->produtos->orderBy('id', 'DESC')
                    ->paginate($this->totalPaginas);
        return view('painel.home.produto.index', compact("produtos"));
    }

    public function criar()
    {
        $paginas = Pagina::all();
        $molduras = MolduraProduto::all();
        return view('painel.home.produto.create_update', compact('paginas','molduras'));
    }

    public function salvar(ProdutoFormRequest $request)
    {
        $dadosDoFormulario = $request->all();
        
        $dadosDoFormulario['user_id'] = auth()->user()->id;

        //dd($dadosDoFormulario['moldura_id']);

        $produtoSalvo = $this->produtos->create($dadosDoFormulario);

        if (isset($dadosDoFormulario['filename'])) {

            foreach ($dadosDoFormulario['filename'] as $image) {

                $imagemProduto = new ImagemProduto;
                $imagemProduto->produto_id = $produtoSalvo->id;

                $renomeiaImagemParaSalvar = uniqid(date('YmdHis')) . '.' . $image->getClientOriginalExtension();
                $uploadDaImagemDoUsuario = $image->storeAs('produtos_galeria', $renomeiaImagemParaSalvar);

                $imagemProduto->nome = $renomeiaImagemParaSalvar;

                $imagemProduto->save();
            }
        }
        if (isset($dadosDoFormulario['moldura_id'])) {
            $molduraSelecionada = $dadosDoFormulario['moldura_id'];
            $molduraProduto = new MolduraProduto;

            foreach ($molduraSelecionada as $key => $item) {
              $molduraProduto = $molduraProduto->find($item);
              $molduraProduto->produtos()->attach($produtoSalvo->id);
            
            }
        }


        if ($produtoSalvo) {
            return redirect()->route('produto.index');
        } else {
            return view('produto.erro')
                ->withErrors(['errors' => 'Erro ao cadastrar'])
                ->with(['errors']);
        }
    }

  
    
    public function deletar($id)
    {
        $produtoRecuperado = $this->produtos->find($id);
        $path_galeria_imagens = public_path("/assets/uploads/produtos_galeria/");

        $nameFileGaleria = $produtoRecuperado->imagemProdutos;

        if (isset($nameFileGaleria)) {
            foreach ($nameFileGaleria as $valor) {
                $deletarGaleriaImagem = File::delete($path_galeria_imagens . $valor->nome);
            }
        }
        if ($deletarGaleriaImagem) {
            $deletarProduto = $produtoRecuperado->delete();

            if ($deletarProduto) {
                return redirect()->route('produto.index');
            } else {
                return view('painel.erros.erro_recuperado')
                    ->withErrors(['errors' => 'Erro ao tentar deletar o usuario ou sua imagem']);
            }
        }
        return view('painel.erros.erro_recuperado')
            ->withErrors(['errors' => 'Erro ao tentar deletar o usuario ou sua imagem']);

    }

   
    public function editar($id)
    {
        $produtoRecuperado = $this->produtos->find($id);
        $paginas = Pagina::all();
        $molduras = MolduraProduto::all();

        return view('painel.home.produto.create_update', compact("produtoRecuperado", "paginas", "molduras"));
    }

    public function atualizar($id, ProdutoFormRequest $request)
    {
        $dadosDoFormulario = $request->all();
        $produtoSelecinado = $this->produtos->find($id);
        if ($request->hasFile('filename')) {
            $galeriaRecuperadaFormulario = $request->file('filename');
            $path_galeria_imagens = public_path("/assets/uploads/produtos_galeria/");

            foreach ($produtoSelecinado->imagemProdutos as $image) {
                $deletarGaleriaImagem = File::delete($path_galeria_imagens . $image->nome);
                $fotosBase = ImagemProduto::find($image->id);
                $fotosBase->delete();
            }

            foreach ($galeriaRecuperadaFormulario as $image) {
                $imagemProduto = new ImagemProduto;
                $imagemProduto->produto_id = $produtoSelecinado->id;

                $renomeiaImagemParaSalvar = uniqid(date('YmdHis')) . '.' . $image->getClientOriginalExtension();
                $uploadDaImagemDoUsuario = $image->storeAs('produtos_galeria', $renomeiaImagemParaSalvar);

                $imagemProduto->nome = $renomeiaImagemParaSalvar;

                $imagemProduto->save();

            }
        }  else {
            $dadosDoFormulario['filename'] = $produtoSelecinado->imagemProdutos;
        } 
        
        $atualizarDadosProduto = $produtoSelecinado->update($dadosDoFormulario);

        if (isset($dadosDoFormulario['moldura_id'])) {
            
            $molduraProduto = new MolduraProduto;
            
            $produtoSelecinado->molduraProduto()->detach();

            $molduraSelecionada = $dadosDoFormulario['moldura_id'];
            foreach ($molduraSelecionada as $key => $item) {
              $molduraProduto = $molduraProduto->find($item);
              $molduraProduto->produtos()->attach($produtoSelecinado->id);
            }
        }

        if ($atualizarDadosProduto) {
            return redirect()->route('produto.index');
        } else {
            return redirect()->route('painel.post.editar', ['id' => $id])
                ->withErrors(['errors' => 'Algo inesperado, aconteceu. ERRO'])
                ->withInput();
        }

    }

    public function pesquisa(Request $request)
    {
        $dadosDoFormularioInseridoPorUsuario = $request->except('_token');
        
        if(!isset($dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario'])) {
            $produtos = $this->produtos->paginate($this->totalPaginas);
            return view('painel.home.produto.index', compact("produtos", "dadosDoFormularioInseridoPorUsuario"));
        }
        $produtos = $this->produtos->where('nome', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario']}%")
            ->paginate($this->totalPaginas);
        return view('painel.home.produto.index', compact("produtos", "dadosDoFormularioInseridoPorUsuario"));

    }
}
