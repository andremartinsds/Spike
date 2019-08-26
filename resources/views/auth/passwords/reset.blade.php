@extends('painel.layouts.app')
@section('menu')
@endsection
@section('content')
<body class="aw-layout-simple-page">
        <div class="aw-layout-simple-page__container">
<form method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
    <div class="aw-simple-panel">
        <img alt="Dom Bosco Premium" src="{{url('assets/painel/images/logo-gray.png')}}" />

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif

		<div class="aw-simple-panel__box">
			<div class="form-group  has-feedback">
                <input id="email" type="email" class="form-control input-lg{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="Endereço de E-Mail">
				<span class="glyphicon  glyphicon-envelope  form-control-feedback" aria-hidden="true"></span>
            </div>
            <div class="form-group  has-feedback">
                <input id="password" type="password" class="form-control input-lg{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Nova Senha">
            </div>
            <div class="form-group  has-feedback">
                <input id="password-confirm" type="password" class="form-control input-lg" name="password_confirmation" required placeholder="Confirmar a nova senha">
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
