<?php

namespace App\Http\Controllers\Painel;
use \App\WebBanner;

use App\Http\Requests\Painel\WebBannerFormRequest;
use File;
class WebBannerController extends Controller
{
    private $webbanner;
    private $totalPaginas = 10;
    public function __construct(WebBanner $webbanner)
    {
        $this->middleware('auth');
        $this->webbanner = $webbanner;
    }
    public function index()
    {
        $webbanners = $this->webbanner->paginate($this->totalPaginas);
        return view('painel.home.webbanner.index', compact("webbanners"));
    }

    public function criar()
    {
        return view('painel.home.webbanner.create_update');
    }

    public function salvar(WebBannerFormRequest $request)
    {
        
        $dadosDoFormulario = $request->all();

       // $dadosDoFormulario['publicado'] = (!isset($dadosDoFormulario['publicado'])) ? 0 : 1;

        //$dadosDoFormulario['user_id'] = auth()->user()->id;


        if (isset($dadosDoFormulario['imagem'])) {
            $recuperaImagemDoFormulario = $request->file('imagem');
            
            $renomeiaImagemParaSalvar = uniqid(date('YmdHis')) . '.' . $recuperaImagemDoFormulario->getClientOriginalExtension();
            $uploadDaImagemDoUsuario = $recuperaImagemDoFormulario->storeAs('webbanners', $renomeiaImagemParaSalvar);
            
            if ($uploadDaImagemDoUsuario) {
                $dadosDoFormulario['imagem'] = $renomeiaImagemParaSalvar;
            } else {
                return view('painel.erros.erro_recuperado')
                    ->withErrors(['errors' => 'Erro ao tentar subir a imagem para o servidor'])
                    ->with([]);
            }
        }

        $salvar = $this->webbanner->create($dadosDoFormulario);

        if ($salvar) {
            return redirect()->route('webbanners');
        } else {
            return view('painel.home.webbanner.index')
                ->withErrors(['errors' => 'Erro ao cadastrar'])
                ->with(['errors']);
        }
    }

    public function editar($id)
    {
        $webbannerRecuperado = $this->webbanner->find($id);
        return view('painel.home.webbanner.create_update', compact("webbannerRecuperado"));
    }

    public function atualizar($id, WebBannerFormRequest $request)
    {
        $dadosDoFormulario = $request->all();
        $webBannerSelecinado = $this->webbanner->find($id);
        if( $request->hasFile('imagem') ) {

            $imagemRecuperadaFormulario = $request->file('imagem');

            //Verifica se o nome da imagem não existe
            if($webBannerSelecinado->imagem == '' ) {
                $nomeDaImagem = uniqid(date('YmdHis')).'.'.$imagemRecuperadaFormulario->getClientOriginalExtension();
                $dadosDoFormulario['imagem'] = $nomeDaImagem;
            }else {
                $nomeDaImagem = $webBannerSelecinado->imagem;
                $dadosDoFormulario['imagem'] = $webBannerSelecinado->imagem;
            }

            $atualizarDadosCategoria = $webBannerSelecinado->update($dadosDoFormulario);

            if ( $atualizarDadosCategoria ) {
                $imagemRecuperadaFormulario->storeAs('webbanners', $nomeDaImagem);
                return redirect()->route('webbanners');
            } else {
                return redirect()->route('painel.post.editar', ['id' => $id])
                    ->withErrors(['errors' => 'Algo inesperado, aconteceu. ERRO'] )
                    ->withInput();
            }

        } else {
            $atualizarDadosCategoria = $webBannerSelecinado->update($dadosDoFormulario);

            if ( $atualizarDadosCategoria ) {
                return redirect()->route('webbanners');
            } else {
                return redirect()->route('painel.post.editar', ['id' => $id])
                    ->withErrors(['errors' => 'Algo inesperado, aconteceu. ERRO'] )
                    ->withInput();
            }
        }


//        $atualizarDadosPost = $postSelecinado->update($dadosDoFormulario);
//
//        if ($atualizarDadosPost) {
//            return redirect()->route('painel.post.index');
//        } else {
//            return redirect()->route('painel.post.editar', ['id' => $id])
//                ->withErrors(['errors' => 'Algo inesperado, aconteceu. ERRO'])
//                ->withInput();
//        }

    }

    public function deletar($id)
    {
        $webbannerRecuperado = $this->webbanner->find($id);

        $path = public_path("/assets/uploads/webbanners/");

        $nameFile = $webbannerRecuperado->imagem;

        if ($nameFile != null) {
            $deletarImagem = File::delete($path . $nameFile);

            if ($deletarImagem) {
                $deletarWebBanner = $webbannerRecuperado->delete();

                if ($deletarWebBanner) {
                    return redirect()->route('webbanners');
                } else {
                    return view('painel.erros.erro_recuperado')
                        ->withErrors(['errors' => 'Erro ao tentar deletar o usuario ou sua imagem']);
                }
            }

        }

        $deletarWebBanner = $webbannerRecuperado->delete();
        if ($deletarWebBanner) {
            return redirect()->route('webbanners');
        } else {
            return view('painel.erros.erro_recuperado')
                ->withErrors(['errors' => 'Erro ao tentar deletar o usuario ou sua imagem']);
        }

        return view('painel.erros.erro_desconhecido');

    }

    public function pesquisa(WebBannerFormRequest $request)
    {
        $dadosDoFormularioInseridoPorUsuario = $request->except('_token');

        if(!isset($dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario'])) {
            $webbanners = $this->webbanner->paginate($this->totalPaginas);
            return view('painel.home.webbanner.index', compact("webbanners", "dadosDoFormularioInseridoPorUsuario"));
        }

        $webbanners = $this->webbanner->where('title', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario']}%")
            ->paginate($this->totalPaginas);
        return view('painel.home.webbanner.index', compact("webbanners", "dadosDoFormularioInseridoPorUsuario"));

    }

    
}
