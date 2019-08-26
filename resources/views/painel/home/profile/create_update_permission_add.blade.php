@extends('painel.templates.template')

@section('content')


<div class="content-din bg-white">
    
    <h2> Cadastro de permissão ao Perfil: {{$profile->name}} </h2>
    
        <form class="form form-search form-ds" method="POST" action=" {{route('painel.profile.permission.add.post', $profile->id)}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            @foreach ($permissions as $permission)
                <div class="form-group">
                <label>
                    <input  class="form-control" type="checkbox" name="permissions[]" value="{{$permission->id}}">
                    {{$permission->name}}
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