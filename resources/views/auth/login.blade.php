@extends('painel.layouts.app')
@section('menu')
<div class="spinner-wrapper" style="display:none">
	<div class="spinner"></div>
</div>
@endsection
@section('content')
<body class="aw-layout-simple-page">
<div class="aw-layout-simple-page__container">
<form method="POST" id="myForm" action="{{ route('login') }}">
    {{ csrf_field() }}
	<div class="aw-simple-panel">
		<img alt="Smvisual" src="{{url('/images/logo.png')}}" width="300"/>
		
		<div class="aw-simple-panel__message">
			Por favor, faça o login.
		</div>
		
		<div class="aw-simple-panel__box">
			<div class="form-group  has-feedback">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} input-lg" name="email" value="{{ old('email') }}" required autofocus placeholder="Seu e-mail">
				<span class="glyphicon  glyphicon-envelope  form-control-feedback" aria-hidden="true"></span>
				
			</div>
			
			<div class="form-group  has-feedback">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} input-lg" name="password" required placeholder="Sua senha">
				<span class="glyphicon  glyphicon-lock  form-control-feedback" aria-hidden="true"></span>
				
				@if ($errors->has('password'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
				@endif
				
				@if ($errors->has('email'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
        		@endif
			</div>
			<div class="form-group">
				<button type="submit" class="btn  btn-primary  btn-lg  aw-btn-full-width">Entrar</button>
			</div>
			
			<div class="form-group clearfix">
				<div class="pull-right">
					<a href="{{ route('password.request') }}" >Esqueceu a senha?</a>
				</div>
			</div>
		</div>
		
		
	</div>
</form>
</div>
</body>
@section('footer')
	
@endsection
@endsection

