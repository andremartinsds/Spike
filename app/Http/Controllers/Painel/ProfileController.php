<?php

namespace App\Http\Controllers\Painel;

use App\Http\Requests\Painel\ProfileFormRequest;
use App\Models\Permission;
use App\Models\Profile;
use App\User;
use Illuminate\Http\Request;
use Gate;

class ProfileController extends Controller
{
    private $profile;
    private $request;
    protected $totalPaginas = 3;

    public function __construct(Profile $profile, ProfileFormRequest $request)
    {
        $this->profile = $profile;
        $this->request = $request;
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::denies('perfil_inicio')) {
            return redirect()->back();
        } else {
            $profiles = $this->profile->paginate($this->totalPaginas);
            return view('painel.home.profile.index', compact("profiles"));
        }
    }

    public function criar()
    {
        if (Gate::denies('perfil_criar')) {
            return redirect()->back();
        } else {
            return view('painel.home.profile.create_update');
        }
    }

    public function salvar()
    {
        if (Gate::denies('perfil_criar')) {
            return redirect()->back();
        } else {
            $dadosDoFormulario = $this->request->all();
            $salvar = $this->profile->create($dadosDoFormulario);
            if ($salvar) {
                return redirect()->route('painel.profile.index');
            } else {
                return view('painel.profile.create_update')
                    ->withErrors(['errors' => 'Erro ao cadastrar'])
                    ->with(['errors']);
            }
        }
    }

    public function vizualizar($id)
    {
        if (Gate::denies('perfil_inicio')) {
            return redirect()->back();
        } else {
            $profileRecuperada = $this->profile->find($id);
            return view('painel.home.profile.show_profile', compact("profileRecuperada"));
        }
    }

    public function editar($id)
    {
        if (Gate::denies('perfil_editar')) {
            return redirect()->back();
        } else {
            $profileRecuperada = $this->profile->find($id);

            return view('painel.home.profile.create_update', compact("profileRecuperada"));
        }
    }

    public function atualizar($id, ProfileFormRequest $request)
    {
        if (Gate::denies('perfil_editar')) {
            return redirect()->back();
        } else {
            $dadosDoFormulario = $request->all();
            $profileSelecinada = $this->profile->find($id);

            $atualizarDadosProfile = $profileSelecinada->update($dadosDoFormulario);

            if ($atualizarDadosProfile) {
                return redirect()->route('painel.profile.index');
            } else {
                return redirect()->route('painel.profile.editar', ['id' => $id])
                    ->withErrors(['errors' => 'Algo inesperado, aconteceu. ERRO'])
                    ->withInput();
            }
        }
    }

    public function deletar($id)
    {
        if (Gate::denies('perfil_deletar')) {
            return redirect()->back();
        } else {
            $profileRecuperada = $this->profile->find($id);

            $deleteProfile = $profileRecuperada->delete();
            if ($deleteProfile) {
                return redirect()->route('painel.profile.index');
            } else {
                return view('painel.erros.erro_recuperado')
                    ->withErrors(['errors' => 'Erro ao tentar deletar o usuario ou sua imagem']);
            }
            return view('painel.erros.erro_desconhecido');
        }
    }

    public function pesquisa()
    {
        $dadosDoFormularioInseridoPorUsuario = $this->request->except('_token');

        $profiles = $this->profile->where('name', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_profile']}%")
            ->paginate($this->totalPaginas);
        return view('painel.home.profile.index', compact("profiles", "dadosDoFormularioInseridoPorUsuario"));

    }

    public function users($id)
    {
        if (Gate::denies('perfil_usuarios')) {
            return redirect()->back();
        } else {
            $profile = $this->profile->find($id);

            $users = $profile->users()->distinct("user_id")->paginate($this->totalPaginas);

            return view('painel.home.profile.profile_user', compact("profile", "users"));
        }
    }

    public function usersAddProfile($id)
    {
        if (Gate::denies('perfil_usuarios')) {
            return redirect()->back();
        } else {
            $profile = $this->profile->find($id);

            //retorne tudo de user que não contenha o id na subquery
            $users = User::whereNotIn("id", function ($query) use ($profile) {
                //na subquery
                $query->select("profile_user.user_id");
                $query->from("profile_user");
                $query->whereRaw("profile_user.profile_id={$profile->id}");

            })->get();

            return view("painel.home.profile.create_update_add", compact("profile", "users"));
        }
    }

    public function usersAddProfilePost(Request $request, $id)
    {
        if (Gate::denies('perfil_usuarios')) {
            return redirect()->back();
        } else {
            $profile = $this->profile->find($id);
            $profile->users()->attach($request->get("users"));
            return redirect()->route("painel.profile.users", compact("id"))->with(['success' => 'Sucesso em adicionar']);
        }
    }

    public function persmissionAddProfile($id)
    {
        if (Gate::denies('perfil_profile')) {
            return redirect()->back();
        } else {
            $profile = $this->profile->find($id);

            //retorne tudo de user que não contenha o id na subquery
            $permissions = Permission::whereNotIn("id", function ($query) use ($profile) {
                //na subquery
                $query->select("permission_profile.permission_id");
                $query->from("permission_profile");
                $query->whereRaw("permission_profile.profile_id={$profile->id}");

            })->get();

            return view("painel.home.profile.create_update_permission_add", compact("profile", "permissions"));
        }
    }

    public function permissionAddProfilePost(ProfileFormRequest $request, $id)
    {
        if (Gate::denies('perfil_profile')) {
            return redirect()->back();
        } else {
            $profile = $this->profile->find($id);
            $profile->permissions()->attach($request->get("permissions"));
            return redirect()->route("painel.profile.permission", compact("id"))->with(['success' => 'Sucesso em adicionar']);
        }
    }

    public function usersDeleteProfile($id, $userId)
    {
        if (Gate::denies('perfil_usuarios')) {
            return redirect()->back();
        } else {
            $profile = $this->profile->find($id);
            $profile->users()->detach($userId);
            return redirect()->route("painel.profile.users", compact("id"))->with(['success' => 'Sucesso em remover']);
        }
    }

    public function profileUser(ProfileFormRequest $request, $id)
    {
        if (Gate::denies('perfil_usuarios')) {
            return redirect()->back();
        } else {
            $dadosDoFormularioInseridoPorUsuario = $request->except('_token');

            $profile = $this->profile->find($id);

            if (!isset($dadosDoFormularioInseridoPorUsuario['inserido_pelo_profile'])) {
                $users = $profile->users()->paginate($this->totalPaginas);
                return view('painel.home.profile.profile_user', compact("users", "dadosDoFormularioInseridoPorUsuario", "profile"));
            }

            $users = $profile->users()
                ->where('users.name', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_profile']}%")
                ->orWhere('users.email', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_profile']}%")
                ->paginate($this->totalPaginas);

            return view("painel.home.profile.profile_user", compact("users", "dadosDoFormularioInseridoPorUsuario", "profile"));
        }
    }

    public function permission($id)
    {
        if (Gate::denies('perfil_profile')) {
            return redirect()->back();
        } else {
            $profile = $this->profile->find($id);
            $permissions = $profile->permissions()->paginate($this->totalPaginas);
            return view('painel.home.profile.profile_permission', compact("profile", "permissions"));
        }
    }
}
