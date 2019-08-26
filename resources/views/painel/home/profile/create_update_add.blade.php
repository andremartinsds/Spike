@extends('painel.templates.template')

@section('content')


<div class="content-din bg-white">
    
    <h2> Cadastro de usuários ao Perfil: {{$profile->name}} </h2>
    
    
    @if(isset($profileRecuperada))
    <form class="form form-search form-ds" method="POST" action="{{route('painel.profile.atualizar', $profileRecuperada->id)}}" enctype="multipart/form-data">
        @else
        <form class="form form-search form-ds" method="POST" action=" {{route('painel.profile.users.add.post', $profile->id)}}" enctype="multipart/form-data">
            @endif    
            {{ csrf_field() }}
            
            @if(isset($errors) && count($errors) > 0)
            <div class="container-fluid alert-danger">
                @foreach($errors->all() as $error)
                <p>{{$error}}</p>
                @endforeach
            </div>
            @endif

            @if(isset($success) && count($success) > 0)
            <div class="container-fluid alert-danger">
                @foreach($success->all() as $succes)
                <p>{{$success}}</p>
                @endforeach
            </div>
            @endif

            @foreach ($users as $user)
                <div class="form-group">
                <label>
                    <input  class="form-control" type="checkbox" name="users[]" value="{{$user->id}}">
                    {{$user->name}}
                </label>
                </div>
            @endforeach
            
            <div class="form-group">
                <button class="btn btn-success" type="submit">Salvar Dados</button>
            </div>
            
        </form>
        
    </div><!--Content Dinâmico-->
    
    @endsection
    
    @push('scripts')
    
    
    {{--<script src="/assets/painel/wysihtml5/advanced.js">--}}
        {{--<script src="/assets/painel/wysihtml5/wysihtml5-0.2.0.min.js">--}}
            
            <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=tduun6j3k2xnv6j3vj8aco9kngslcd98fjtlbhcukaydtucp"></script>
            <script>tinymce.init({ selector:'textarea' });</script>
            @endpush