@extends('painel.templates.template')

@section('content')

    <div class="title-pg">
    <h1 class="title-pg">Permissão: {{$permission->name}}</h1>
    </div>

    <div class="content-din bg-white">

      <div class="form-search">
            <form action="{{route('permission.pesquisa.profiles', $permission->id)}}" class="form form-inline">
                <input type="text" name="inserido_pela_permission" placeholder="Digite algo para Pesquisa" class="form-control">

               <button class="btn btn-success" type="submit">Pesquisar</button>
            </form>
      </div>

        <div class="class-btn-insert">
            <a href="{{route('permission.profile.add', $permission->id)}}" class="btn-insert">
                <span class="glyphicon glyphicon-plus"></span>
                Vincular permissão a perfil
            </a>
        </div>
        @if(isset($success) && count($success) > 0)
        <div class="container-fluid alert-danger">
            @foreach($success->all() as $succes)
            <p>{{$success}}</p>
            @endforeach
        </div>
        @endif

        <table class="table table-striped">
            <tr>
                <th>Nome</th>
                <th>Label</th>
                <th width="200">Ações</th>
            </tr>

            @foreach($profiles as $profile)
            <tr>
                <td>{{$profile->name}}</td>
                <td>{{$profile->label}}</td>
                <td>
                    <a href="{{route('permission.profile.delete',[$permission->id, $profile->id])}}" class="edit"></span>Remover do perfil</a>
                </td>
            </tr>
            @endforeach
        </table>
        @if(isset($dadosDoFormularioInseridoPorUsuario))
            {{$profiles->appends($dadosDoFormularioInseridoPorUsuario)->links()}}
        @else
            {{$profiles->links()}}
        @endif

    </div><!--Content Dinâmico-->

@endsection

