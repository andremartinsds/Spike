@extends('painel.layouts.app')
@section('menu')

@endsection
@section('content')
<body class="aw-layout-simple-page">
        <div class="aw-layout-simple-page__container">
<form method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}
    <div class="aw-simple-panel">
        <img alt="Dom Bosco Premium" src="{{url('assets/painel/images/logo-gray.png')}}" />
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
		
		<div class="aw-simple-panel__message">
			Informe o seu e-mail abaixo para receber as instruções de como criar uma nova senha.
		</div>
		
		<div class="aw-simple-panel__box">
			<div class="form-group  has-feedback">
                    <input id="email" type="email" class="form-control  input-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Seu E-mail">
				<span class="glyphicon  glyphicon-envelope  form-control-feedback" aria-hidden="true"></span>
			</div>
			
			<div class="form-group">
			<button type="submit" class="btn  btn-primary  btn-lg  aw-btn-full-width">Criar nova senha</button>
			</div>
		</div>
    </div>
</form>  
        </div>
</body>
@endsection
