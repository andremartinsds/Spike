<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Produto;
use App\Pedido;
use App\Pagina;
use App\Http\Requests\Painel\ProdutoFormRequest;
use App\ImagemProduto;
use File;
use App\FasePedido;

class PedidoControllerCliente extends Controller
{
    private $pedidos;
    private $produtos;
    private $fasePedido;
    private $totalPaginas = 10;
    public function __construct(Produto $produtos, Pedido $pedidos, FasePedido $fasePedido)
    {
        $this->produtos = $produtos;
        $this->pedidos = $pedidos;
        $this->fasePedido = $fasePedido;
        $this->middleware('auth');
    }

    public function index()
    {
        $pedidos = $this->pedidos->paginate($this->totalPaginas);
        return view('painel.home.pedido.index', compact("pedidos"));
    }

    public function criar()
    {
        $paginas = Pagina::all();
        return view('painel.home.produto.create_update', compact('paginas'));
    }

    public function salvar($id, Request $request)
    {
        $dadosDoFormulario = $request->all();
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
        $pedidoRecuperado = $this->pedidos->find($id);
        return view('painel.home.pedido.create_update', compact("pedidoRecuperado"));
    }

    public function atualizarFasePedido($id, Request $request)
    {
        $pedido = $this->pedidos->find($id);
        $fasePedido = new FasePedido();
        
        
        $fasePedido->fase = $request->input("fase_pedido");

        switch($fasePedido->fase) {
            case "0" : $fasePedido->fase = "NÃO ANALISADO";
            break;

            case "1" : $fasePedido->fase = "PAGO";
            break;

            case "2" : $fasePedido->fase = "PRÉ-IMPRESSÃO";
            break;

            case "3" : $fasePedido->fase = "PRODUÇÃO";
            break;

            case "4" : $fasePedido->fase = "EXPEDIÇÃO";
            break;

            case "5" : $fasePedido->fase = "CONCLUÍDO";
            break;

            case "6" : $fasePedido->fase = "ENVIADO";
            break;
        }
        $fasePedido->id_pedido = $pedido->id;
        $fasePedido->save();

        if ($fasePedido) {
            return redirect()->route('pedido.editar',$id);
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
            $pedidos = $this->pedidos->paginate($this->totalPaginas);
            return view('painel.home.pedido.index', compact("pedidos", "dadosDoFormularioInseridoPorUsuario"));
        }
        $pedidos = $this->pedidos->where('subtotal', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario']}%")
            ->paginate($this->totalPaginas);
        return view('painel.home.pedido.index', compact("pedidos", "dadosDoFormularioInseridoPorUsuario"));

    }
}
