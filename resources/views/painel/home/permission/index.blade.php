@extends('painel.templates.template')

@section('content')

    <div class="title-pg">
        <h1 class="title-pg">Permissões</h1>
    </div>

    <div class="content-din bg-white">

      <div class="form-search">
            <form action="{{route('painel.profile.pesquisa')}}" class="form form-inline">
                <input type="text" name="inserido_pelo_profile" placeholder="Digite algo para Pesquisa" class="form-control">

               <button class="btn btn-success" type="submit">Pesquisar</button>
            </form>
        </div>

        <div class="class-btn-insert">
            <a href="{{route('painel.permission.criar')}}" class="btn-insert">
                <span class="glyphicon glyphicon-plus"></span>
                Cadastrar
            </a>
        </div>

        <table class="table table-striped">
            <tr>
                <th>Nome</th>
                <th>Label</th>
                <th width="600">Ações</th>
            </tr>

            @foreach($permissions as $permission)
            <tr>
                <td>{{$permission->name}}</td>
                <td>{{$permission->label}}</td>
                <td>
                    <a href="{{route('painel.permission.editar',$permission->id)}}" class="edit"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
                    <a href="{{route('painel.permission.profile', $permission->id)}}" class="delete"><span class="glyphicon glyphicon-eye-open"></span>Perfis Vinculados</a>
                    <a href="{{route('painel.permission.vizualizar', $permission->id)}}" class="delete"><span class="glyphicon glyphicon-eye-open"></span> Delete</a>
                </td>
            </tr>
            @endforeach
        </table>
        @if(isset($dadosDoFormularioInseridoPorUsuario))
            {{$permissions->appends($dadosDoFormularioInseridoPorUsuario)->links()}}
        @else
            {{$permissions->links()}}
        @endif

    </div><!--Content Dinâmico-->

@endsection

