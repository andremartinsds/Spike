<?php

namespace App\Http\Controllers\Painel;

use App\Http\Requests\Painel\PermissionFormRequest;
use App\Models\Permission;
use Gate;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $permission;
    private $request;
    protected $totalPaginas = 10;

    public function __construct(Permission $permission, PermissionFormRequest $request)
    {
        $this->permission = $permission;
        $this->request = $request;
        $this->middleware('auth');
    }

    public function index()
    {
        if (Gate::denies('permission_inicio')) {
            return redirect()->back();
        } else {
            $permissions = $this->permission
                ->orderBy('name', 'ASC')
                ->paginate($this->totalPaginas);
            return view('painel.home.permission.index', compact("permissions"));
        }
    }

    public function criar()
    {
        if (Gate::denies('permission_criar')) {
            return redirect()->back();
        } else {
            return view('painel.home.permission.create_update');
        }
    }

    public function salvar()
    {
        if (Gate::denies('permission_criar')) {
            return redirect()->back();
        } else {
            $dadosDoFormulario = $this->request->all();
            $salvar = $this->permission->create($dadosDoFormulario);
            if ($salvar) {
                return redirect()->route('painel.permission.index');
            } else {
                return view('painel.profile.create_update')
                    ->withErrors(['errors' => 'Erro ao cadastrar'])
                    ->with(['errors']);
            }
        }
    }

    public function vizualizar($id)
    {
        if (Gate::denies('permission_inicio')) {
            return redirect()->back();
        } else {
            $permissionRecuperada = $this->permission->find($id);
            return view('painel.home.permission.show_profile', compact("permissionRecuperada"));
        }
    }

    public function editar($id)
    {
        if (Gate::denies('permission_editar')) {
            return redirect()->back();
        } else {
            $permissionRecuperada = $this->permission->find($id);

            return view('painel.home.permission.create_update', compact("permissionRecuperada"));
        }
    }

    public function atualizar($id, PermissionFormRequest $request)
    {
        if (Gate::denies('permission_editar')) {
            return redirect()->back();
        } else {
            $dadosDoFormulario = $request->all();
            $permissionSelecinada = $this->permission->find($id);

            $atualizarDadosPermission = $permissionSelecinada->update($dadosDoFormulario);

            if ($atualizarDadosPermission) {
                return redirect()->route('painel.permission.index');
            } else {
                return redirect()->route('painel.permission.editar', ['id' => $id])
                    ->withErrors(['errors' => 'Algo inesperado, aconteceu. ERRO'])
                    ->withInput();
            }
        }
    }

    public function deletar($id)
    {
        if (Gate::denies('permission_deletar')) {
            return redirect()->back();
        } else {
            $permissionRecuperada = $this->permission->find($id);

            $deletePermission = $permissionRecuperada->delete();
            if ($deletePermission) {
                return redirect()->route('painel.permission.index');
            } else {
                return view('painel.erros.erro_recuperado')
                    ->withErrors(['errors' => 'Erro ao tentar deletar o usuario ou sua imagem']);
            }

            return view('painel.erros.erro_desconhecido');
        }
    }

    // public function pesquisa()
    // {
    //     $dadosDoFormularioInseridoPorUsuario = $this->request->except('_token');

    //     $profiles = $this->profile->where('name', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pelo_profile']}%")
    //     ->paginate($this->totalPaginas);
    //     return view('painel.home.profile.index', compact("profiles", "dadosDoFormularioInseridoPorUsuario"));

    // }

    public function profiles($id)
    {
        if (Gate::denies('permission_profile')) {
            return redirect()->back();
        } else {
            $permission = $this->permission->find($id);

            $profiles = $permission->profiles()->paginate($this->totalPaginas);

            return view('painel.home.permission.permission_profile', compact("permission", "profiles"));
        }
    }

    public function permissionAddProfile($id)
    {
        if (Gate::denies('permission_profile')) {
            return redirect()->back();
        } else {
            $permission = $this->permission->find($id);

            //retorne tudo de user que não contenha o id na subquery
            $profiles = Permission::whereNotIn("id", function ($query) use ($permission) {
                //na subquery
                $query->select("permission_profile.profile_id");
                $query->from("permission_profile");
                $query->whereRaw("permission_profile.permission_id={$permission->id}");

            })->get();
            return view("painel.home.permission.create_update_add", compact("permission", "profiles"));
        }
    }

    public function permissionAddProfilePost(Request $request, $id)
    {
        if (Gate::denies('permission_profile')) {
            return redirect()->back();
        } else {
            $permission = $this->permission->find($id);
            $permission->profiles()->attach($request->get("profiles"));
            return redirect()->route("painel.permission.profile", compact("id"))->with(['success' => 'Sucesso em adicionar']);
        }

    }

    public function permissionDeleteProfile($id, $profileId)
    {
        if (Gate::denies('permission_profile')) {
            return redirect()->back();
        } else {
            $permission = $this->permission->find($id);
            $permission->profiles()->detach($profileId);
            return redirect()->route("painel.permission.profile", compact("id"))->with(['success' => 'Sucesso em remover']);
        }
    }

    public function permissionProfile(PermissionFormRequest $request, $id)
    {
        $dadosDoFormularioInseridoPorUsuario = $request->except('_token');

        $permission = $this->permission->find($id);

        if (!isset($dadosDoFormularioInseridoPorUsuario['inserido_pela_permission'])) {
            $profiles = $permission->profiles()->paginate($this->totalPaginas);
            return view('painel.home.permission.permission_profile', compact("profiles", "dadosDoFormularioInseridoPorUsuario", "permission"));
        }

        $profiles = $permission->profiles()
            ->where('profiles.name', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pela_permission']}%")
            ->orWhere('profiles.label', 'LIKE', "%{$dadosDoFormularioInseridoPorUsuario['inserido_pela_permission']}%")
            ->paginate($this->totalPaginas);

        return view('painel.home.permission.permission_profile', compact("profiles", "dadosDoFormularioInseridoPorUsuario", "permission"));

    }
}
