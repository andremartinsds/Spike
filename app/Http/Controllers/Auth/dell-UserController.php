<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;    
    }

    public function editar($id) {
        $user = $this->user->find($id);
        return view("auth.update", compact("user"));
    }

    public function atualizarUsuario($id, Request $request) {
        $userSelecionado = $this->user->find($id);
        
        if($request->input('password') != $request->input('password_confirmation')) {
            return redirect()->route('editar.usuario', ['id' => $id])
                ->withErrors(['errors' => 'você precisa aplicar duas senhas iguais'])
                ->withInput();
        }

        $userSelecionado->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        if($userSelecionado) {
            return redirect()->route("usuarios.todos");
        } else {
            return redirect()->route('editar.usuario', ['id' => $id])
                ->withErrors(['errors' => 'Opa :( erro inesperado, contate o suporte do sistema'])
                ->withInput();
        }
    }


    
    public function deletarUsuario($id)
    {
        $userSelecionado = $this->user->find($id);
        $usuarios = $this->user->all();
        $userSelecionado = $userSelecionado->delete();
        if ($userSelecionado) {
            return view ('painel.home.user.index', compact('usuarios'));
        } else {
            return redirect()->view('auth.delete', ['id' => $id])
                ->withErrors(['errors' => 'Algo inesperado aconteceu e não conseguimos deletar o usuário'])
                ->withInput();
        }

        return view('painel.erros.erro_desconhecido');
    }
}
