@extends('painel.templates.template')

@section('content')


    <div class="content-din bg-white">

        <h2> Post </h2>


        <form class="form form-search form-ds" method="POST"
              action="{{route('painel.profile.deletar', $profileRecuperada->id)}}" enctype="multipart/form-data">

            {{ csrf_field() }}

            @if(isset($errors) && count($errors) > 0)
                <div class="container-fluid alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                </div>
            @endif

            <div class="alert alert-info" role="alert">
                <h4>
                    <strong>Nome: </strong>
                    {{$profileRecuperada->name}}

                    </br>

                    <strong>Label: </strong>
                    {!!  $profileRecuperada->label !!}

                    </br>
                </h4>
            </div>
            <button class="btn btn-danger" type="submit"> Excluir ( {{$profileRecuperada->name}} )</button>
        </form>

    </div><!--Content Dinâmico-->

@endsection