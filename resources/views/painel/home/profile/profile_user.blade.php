@extends('painel.templates.template')

@section('content')

    <div class="title-pg">
    <h1 class="title-pg">Perfil: {{$profile->name}}</h1>
    </div>

    <div class="content-din bg-white">

      <div class="form-search">
            <form action="{{route('profile.pesquisa.users', $profile->id)}}" class="form form-inline">
                <input type="text" name="inserido_pelo_profile" placeholder="Digite algo para Pesquisa" class="form-control">

               <button class="btn btn-success" type="submit">Pesquisar</button>
            </form>
      </div>

        <div class="class-btn-insert">
            <a href="{{route('painel.profile.users.add', $profile->id)}}" class="btn-insert">
                <span class="glyphicon glyphicon-plus"></span>
                Cadastrar
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

            @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <a href="{{route('profile.user.delete',[$profile->id, $user->id])}}" class="edit"></span>Remover do perfil</a>
                </td>
            </tr>
            @endforeach
        </table>
        @if(isset($dadosDoFormularioInseridoPorUsuario))
            {{$users->appends($dadosDoFormularioInseridoPorUsuario)->links()}}
        @else
            {{$users->links()}}
        @endif

    </div><!--Content Dinâmico-->

@endsection

