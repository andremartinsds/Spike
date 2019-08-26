<?php

namespace App\Http\Controllers\Painel;

use App\Http\Requests\Painel\UserRequest;
use App\User;
use File;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests\Painel\UserFormRequest;

class UserController extends Controller
{
    private $user, $request;
    protected $totalPaginas = 10;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('auth');
    }

    public function index()
    {
        $usuarios = $this->user->paginate($this->totalPaginas);
        return view('painel.home.user.index', compact("usuarios"));
    }

    public function criar()
    {
        return view('painel.home.user.create_update');
    }

    public function salvar(UserRequest $request)
    {
        $dadosDoFormulario = $request->all();
        $dadosDoFormulario["password"] = bcrypt($dadosDoFormulario["password"]);

        if ($request->hasFile('image')) {
            $recuperaImagemDoFormulario = $request->file('image');
            $renomeiaImagemParaSalvar = uniqid(date('YmdHis')) . '.' . $recuperaImagemDoFormulario->getClientOriginalExtension();
            $uploadDaImagemDoUsuario = $recuperaImagemDoFormulario->storeAs('users', $renomeiaImagemParaSalvar);
            if ($uploadDaImagemDoUsuario) {
                $dadosDoFormulario['image'] = $renomeiaImagemParaSalvar;
            } else {
                return view('painel.erros.erro_recuperado')
                    ->withErrors(['errors' => 'Erro ao tentar subir a imagem para o servidor'])
                    ->with([]);
            }

        }

        $salvar = $this->user->create($dadosDoFormulario);

        if ($salvar) {
            return redirect()->route('painel.usuario.index');
        } else {
            return view('painel.erros.erro_desconhecido');
        }
    }

    public function editar($id)
    {
        $user = $this->user->find($id);

        return view('painel.home.user.update', compact("user"));
    }

    public function atualizar($id, UserFormRequest $request)
    {
        //Pega todos os dados do usuário
        $dataUser = $request->all();

        //recupera o usuário da instancia
        $user = $this->user->find($id);

        //Criptografa a senha
        if (isset($dataUser['password']) && $dataUser['password'] != '') {
            $dataUser['password'] = bcrypt($dataUser['password']);
        }

        // //Verifica se existe a imagem
        // if ($request->hasFile('image')) {
        //     //recupera a imagem
        //     $image = $request->file('image');

        //     //Verifica se o nome da imagem não existe
        //     if ($user->image == '') {
        //         $nameImage = uniqid(date('YmdHis')) . '.' . $image->getClientOriginalExtension();
        //         $dataUser['image'] = $nameImage;
        //     } else {
        //         $nameImage = $user->image;
        //         $dataUser['image'] = $user->image;
        //     }

        //     $upload = $image->storeAs('users', $nameImage);

        //     if (!$upload) {
        //         return redirect()->route('painel.usuario.editar', ['id' => $id])
        //             ->withErrors(['errors' => 'Erro no Upload'])
        //             ->withInput();
        //     }

        // }

        // //Altera os dados do usuário
        $update = $user->update($dataUser);

        if ($update) {
            return redirect()
                ->route('usuarios.todos')
                ->with(['success' => 'Alteração realizada com sucesso!']);
        } else {
            return redirect()->route('home');
        }

    }

    public function vizualizar($id)
    {
        $user = $this->user->find($id);
        return view('painel.home.user.delete', compact("user"));
    }

    public function paginaDelete($id)
    {
        $user = $this->user->find($id);
        return view("painel.home.user.delete", compact("user"));
    }

    public function deletar($id)
    {
        $usuarioRecuperado = $this->user->find($id);
        $deletarUsuario = $usuarioRecuperado->delete();
        if($deletarUsuario) {
            return redirect()->route('usuarios.todos');
        } else {
            return redirect()->route('home');
        }

        $path = public_path("\\assets\\uploads\\users\\");

        $nameFile = $usuarioRecuperado->image;

        if ($nameFile != null) {
            $deletarImagem = File::delete($path . $nameFile);

            if ($deletarImagem) {
                $deletarUsuario = $usuarioRecuperado->delete();

                if ($deletarUsuario) {
                    return redirect()->route('painel.usuario.index');
                } else {
                    return view('painel.erros.erro_recuperado')
                        ->withErrors(['errors' => 'Erro ao tentar deletar o usuario ou sua imagem']);
                }
            }

        }

        $deletarUsuario = $usuarioRecuperado->delete();
        if ($deletarUsuario) {
            return redirect()->route('painel.usuario.index');
        } else {
            return view('painel.erros.erro_recuperado')
                ->withErrors(['errors' => 'Erro ao tentar deletar o usuario ou sua imagem']);
        }

        return view('painel.erros.erro_desconhecido');

    }

    public function pesquisa()
    {
        $dadosDoFormularioInseridoPorUsuario = $this->request->except('_token');

        $users = $this->user->where('name', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario']}%")
            ->orWhere('email', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario']}%")
            ->orWhere('cpf', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_usuario']}%")
            ->paginate($this->totalPaginas);
        return view('painel.home.user.index', compact("users", "dadosDoFormularioInseridoPorUsuario"));

    }

    public function perfil()
    {
        $usuarioRecuperado = auth()->user();
        return view('painel.home.user.perfil', compact("usuarioRecuperado"));

    }

    public function updateUsuarioLogado($id, UserRequest $request)
    {
        //Pega todos os dados do usuário
        $dataUser = $request->except('email');

        //recupera o usuário da instancia
        $user = $this->user->find($id);
        //unset($user['email']);

        //Criptografa a senha
        if (isset($dataUser['password']) && $dataUser['password'] != '') {
            $dataUser['password'] = bcrypt($dataUser['password']);
        }

        //Verifica se existe a imagem
        if ($request->hasFile('image')) {
            //recupera a imagem
            $image = $request->file('image');

            //Verifica se o nome da imagem não existe
            if ($user->image == '') {
                $nameImage = uniqid(date('YmdHis')) . '.' . $image->getClientOriginalExtension();
                $dataUser['image'] = $nameImage;
            } else {
                $nameImage = $user->image;
                $dataUser['image'] = $user->image;
            }

            $upload = $image->storeAs('users', $nameImage);

            if (!$upload) {
                return redirect()->route('perfil', ['id' => $id])
                    ->withErrors(['errors' => 'Erro no Upload'])
                    ->withInput();
            }

        }

        //Altera os dados do usuário
        $update = $user->update($dataUser);

        if ($update) {
            return redirect()
                ->route('perfil')
                ->with(['success' => 'Alteração realizada com sucesso!']);
        } else {
            return redirect()->route('perfil', ['id' => $id])
                ->withErrors(['errors' => 'Falha ao editar'])
                ->withInput();
        }

    }

    public function perfis($id)
    {
        $user = $this->user->find($id);
        $profiles = $user->profiles()->paginate($this->totalPaginas);

        // $users = $profile->users()->distinct("user_id")->paginate($this->totalPaginas);

        return view('painel.home.user.user_profile', compact("profiles", "user"));
    }

}
