@component('mail::message')
@slot('header')
@component('mail::header', ['url' => config('app.url')])
Dom Bosco Premium
@endcomponent
@endslot
# Olá {{ $name }}
Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para sua conta.
@component('mail::button', ['url' => $url])
Resetar Senha
@endcomponent
Dom Bosco Premium<br>
{{ config('app.name') }}
@component('mail::subcopy', ['url' => $url])
Link direto [{{ $url}}]({{ $url}})
@endcomponent
@endcomponent