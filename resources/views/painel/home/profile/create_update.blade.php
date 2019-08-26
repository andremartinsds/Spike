@extends('painel.templates.template')

@section('content')


<div class="content-din bg-white">
    
    <h2> Formulário de Perfil </h2>
    
    
    @if(isset($profileRecuperada))
    <form class="form form-search form-ds" method="POST" action="{{route('painel.profile.atualizar', $profileRecuperada->id)}}" enctype="multipart/form-data">
        @else
        <form class="form form-search form-ds" method="POST" action="   {{route('painel.profile.salvar')}}" enctype="multipart/form-data">
            @endif    
            {{ csrf_field() }}
            
            @if(isset($errors) && count($errors) > 0)
            <div class="container-fluid alert-danger">
                @foreach($errors->all() as $error)
                <p>{{$error}}</p>
                @endforeach
            </div>
            @endif

            <div class="form-group">
                <label>Nome</label>
                <input value="{{ isset($profileRecuperada->name) ? $profileRecuperada->name : old('name') }}" id="name" class="form-control" type="text" name="name">
            </div>

            <div class="form-group">
                <label>Label</label>
                <input value="{{ isset($profileRecuperada->label) ? $profileRecuperada->label : old('label') }}" id="label" class="form-control" type="text" name="label">
            </div>
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