@extends('painel.templates.template')

@section('content')

    <div class="title-pg">
        <h1 class="title-pg">Perfil</h1>
    </div>

    <div class="content-din bg-white">

      <div class="form-search">
            <form action="{{route('painel.profile.pesquisa')}}" class="form form-inline">
                <input type="text" name="inserido_pelo_profile" placeholder="Digite algo para Pesquisa" class="form-control">

               <button class="btn btn-success" type="submit">Pesquisar</button>
            </form>
        </div>

        <div class="class-btn-insert">
            <a href="{{route('painel.profile.criar')}}" class="btn-insert">
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

            @foreach($profiles as $profile)
            <tr>
                <td>{{$profile->name}}</td>
                <td>{{$profile->label}}</td>
                <td>
                    <a href="{{route('painel.profile.editar',$profile->id)}}" class="edit"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
                    <a href="{{route('painel.profile.vizualizar', $profile->id)}}" class="delete"><span class="glyphicon glyphicon-eye-open"></span> Vizualizar</a>
                    <a href="{{route('painel.profile.users', $profile->id)}}" class="delete"><span class="glyphicon glyphicon-eye-open"></span> Usuários Vinculados</a>
                    <a href="{{route('painel.profile.permission', $profile->id)}}" class="delete"><span class="glyphicon glyphicon-eye-open"></span> Permissões Vinculadas</a>
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

