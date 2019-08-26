<?php

// Rotas protegidas
#####################################################################################################
Route::get('/home', 'Painel\HomeController@index')->name('home');

// Rotas de autenticação
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Rotas para redefinição de senha
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('usuarios/todos', 'Painel\UserController@index')->name('usuarios.todos');
Route::get('editar/usuario/{id}', 'Painel\UserController@editar')->name('editar.usuario');
Route::post('editar/usuario/{id}', 'Painel\UserController@atualizar')->name('atualizar.usuario');
Route::get('deletar/usuario/{id}', 'Painel\UserController@paginaDelete')->name('seleciona.delete.usuario');
Route::post('deletar/user/{id}', 'Painel\UserController@deletar')->name('deletar.usuario');

// Rotas para  WEBBANNER
#####################################################################################################
Route::get('/webbanner/inicio','Painel\WebBannerController@index')->name('webbanners');

Route::get('/webbanner/criar','Painel\WebBannerController@criar')->name('webbanner.criar');

Route::post('/webbanner/salvar', 'Painel\WebBannerController@salvar')->name('webbanner.salvar');

Route::get('/webbanner/{id}/editar', 'Painel\WebBannerController@editar')->name('webbanner.editar');

Route::post('/webbanner/{id}/atualizar/', 'Painel\WebBannerController@atualizar')->name('webbanner.atualizar');

Route::get('/clientes/{id}/vizualizar', 'Painel\WebBannerController@vizualizar')->name('webbanner.vizualizar');

Route::get('/webbanner/{id}/deletar', 'Painel\WebBannerController@deletar')->name('webbanner.deletar');

Route::any('/webbanner/pesquisa', 'Painel\WebBannerController@pesquisa')->name('webbanner.pesquisa');
#####################################################################################################
// FIM DAS ROTAS PARA WEBBANNER

#####################################################################################################
// INICIO DAS ROTAS PARA NOTICIAS

 Route::get('/noticias/inicio','Site\NoticiasController@index')->name('noticias.index');

 Route::get('/noticias/criar','Site\NoticiasController@criar')->name('noticia.criar');

 Route::post('/noticias/salvar', 'Site\NoticiasController@salvar')->name('noticia.salvar');

 Route::get('/noticias/{id}/editar', 'Site\NoticiasController@editar')->name('noticia.editar');

 Route::post('/noticias/{id}/atualizar/', 'Site\NoticiasController@atualizar')->name('noticia.atualizar');

 Route::get('/noticias/{id}/deletar', 'Site\NoticiasController@deletar')->name('noticia.deletar');

 Route::any('/noticias/pesquisa', 'Site\NoticiasController@pesquisa')->name('noticia.pesquisa');

#####################################################################################################
// FIM DAS ROTAS PARA NOTICIAS

#####################################################################################################
// INICIO DAS ROTAS PARA CATEGORIAS

Route::get('/categoria/inicio','Painel\CategoriaController@index')->name('categoria.index');

Route::get('/mandae','Painel\CategoriaController@mandaEmail');

Route::get('/categoria/criar','Painel\CategoriaController@criar')->name('categoria.criar');

Route::post('/categoria/salvar', 'Painel\CategoriaController@salvar')->name('categoria.salvar');

Route::get('/categoria/{id}/editar', 'Painel\CategoriaController@editar')->name('categoria.editar');

Route::post('/categoria/{id}/atualizar/', 'Painel\CategoriaController@atualizar')->name('categoria.atualizar');

Route::get('/categoria/{id}/deletar', 'Painel\CategoriaController@deletar')->name('categoria.deletar');

Route::any('/categoria/pesquisa', 'Painel\CategoriaController@pesquisa')->name('categoria.pesquisa');

#####################################################################################################
// FIM DAS ROTAS PARA CATEGORIAS


#####################################################################################################
// INICIO DAS ROTAS PARA CATEGORIAS

Route::get('/moldura/inicio','Painel\MolduraController@index')->name('moldura.index');

Route::get('/moldura/criar','Painel\MolduraController@criar')->name('moldura.criar');

Route::post('/moldura/salvar', 'Painel\MolduraController@salvar')->name('moldura.salvar');

Route::get('/moldura/{id}/editar', 'Painel\MolduraController@editar')->name('moldura.editar');

Route::post('/moldura/{id}/atualizar/', 'Painel\MolduraController@atualizar')->name('moldura.atualizar');

Route::get('/moldura/{id}/deletar', 'Painel\MolduraController@deletar')->name('moldura.deletar');

Route::any('/moldura/pesquisa', 'Painel\MolduraController@pesquisa')->name('moldura.pesquisa');

#####################################################################################################
// FIM DAS ROTAS PARA CATEGORIAS


#####################################################################################################
// INICIO DAS ROTAS PARA PRODUTOS

Route::get('/produto/inicio','Painel\ProdutoController@index')->name('produto.index');

Route::get('/produto/criar','Painel\ProdutoController@criar')->name('produto.criar');

Route::post('/produto/salvar', 'Painel\ProdutoController@salvar')->name('produto.salvar');

Route::get('/produto/{id}/editar', 'Painel\ProdutoController@editar')->name('produto.editar');

Route::post('/produto/{id}/atualizar/', 'Painel\ProdutoController@atualizar')->name('produto.atualizar');

Route::get('/produto/{id}/deletar', 'Painel\ProdutoController@deletar')->name('produto.deletar');

Route::any('/produto/pesquisa', 'Painel\ProdutoController@pesquisa')->name('produto.pesquisa');

#####################################################################################################
// FIM DAS ROTAS PARA PRODUTOS

#####################################################################################################
// INICIO DAS ROTAS PARA PRODUTOS

Route::get('/pedido/inicio','Painel\PedidoControllerCliente@index')->name('pedidos.index');

// Route::get('/pedido/criar','Painel\PedidoControllerCliente@criar')->name('pedido.criar');

// Route::post('/pedido/salvar', 'Painel\PedidoControllerCliente@salvar')->name('pedido.salvar');

Route::get('/pedido/{id}/editar', 'Painel\PedidoControllerCliente@editar')->name('pedido.editar');

Route::post('/pedido/{id}/atualizar/', 'Painel\PedidoControllerCliente@atualizarFasePedido')->name('pedido.atualizar.fase.pedido');

// Route::get('/pedido/{id}/deletar', 'Painel\PedidoControllerCliente@deletar')->name('pedido.deletar');

Route::any('/pedido/pesquisa', 'Painel\PedidoControllerCliente@pesquisa')->name('pedido.pesquisa');

#####################################################################################################
// FIM DAS ROTAS PARA PRODUTOS

#####################################################################################################
// INICIO DAS ROTAS PARA PEDIDO CLIENTE

Route::post('/comprovante/{id}/salvar', 'Site\ClienteSiteController@salvar')->name('pedido.comprovante');

#####################################################################################################
// FIM DAS ROTAS PARA PEDIDO AREA DO CLIENTE



#####################################################################################################
// INICIO DAS ROTAS PARA PAGINA

Route::get('/pagina/inicio','Painel\PaginaController@index')->name('pagina.index');

Route::get('/pagina/criar','Painel\PaginaController@criar')->name('pagina.criar');

Route::post('/pagina/salvar', 'Painel\PaginaController@salvar')->name('pagina.salvar');

Route::get('/pagina/{id}/editar', 'Painel\PaginaController@editar')->name('pagina.editar');

Route::post('/pagina/{id}/atualizar/', 'Painel\PaginaController@atualizar')->name('pagina.atualizar');

Route::get('/pagina/{id}/deletar', 'Painel\PaginaController@deletar')->name('pagina.deletar');

Route::any('/pagina/pesquisa', 'Painel\PaginaController@pesquisa')->name('pagina.pesquisa');

#####################################################################################################
// FIM DAS ROTAS PARA PAGINA

#####################################################################################################
// INICIO DAS ROTAS PARA CLIENTE

Route::get('/cliente/inicio','Painel\ClienteController@index')->name('cliente.index');

Route::get('/cliente/criar','Painel\ClienteController@criar')->name('cliente.criar');

Route::post('/cliente/salvar', 'Painel\ClienteController@salvar')->name('cliente.salvar');

Route::get('/cliente/{id}/editar', 'Painel\ClienteController@editar')->name('cliente.editar');

Route::post('/cliente/{id}/atualizar/', 'Painel\ClienteController@atualizar')->name('cliente.atualizar');

Route::get('/cliente/{id}/deletar', 'Painel\ClienteController@deletar')->name('cliente.deletar');

Route::any('/cliente/pesquisa', 'Painel\ClienteController@pesquisa')->name('cliente.pesquisa');

#####################################################################################################
// FIM DAS ROTAS PARA CLIENTE

#####################################################################################################
// INICIO DAS ROTAS PARA PROJETOS

#####################################################################################################
// FIM DAS ROTAS PARA PROJETOS

// Rotas para  CONTATO
#####################################################################################################
Route::get('/contato/inicio','ContatoController@index')->name('contatos');

Route::get('/contato/{id}/vizualizar', 'ContatoController@vizualizar')->name('contato.vizualizar');

Route::get('/contato/{id}/deletar', 'ContatoController@deletar')->name('contato.deletar');

Route::any('/contato/pesquisa', 'ContatoController@pesquisa')->name('contato.pesquisa');
#####################################################################################################
// FIM DAS ROTAS PARA CONTATO

// INICIO DAS ROTAS PARA SITE INSTITUCIONAL
#####################################################################################################

Route::get('/vejamais', function () {
    return view('vejamais');
});
Route::get('/inicio','Site\InstitucionalController@inicio')->name('inicio');
Route::get('/index','Site\InstitucionalController@index');   
Route::get('/colegio','Site\InstitucionalController@colegio');   
Route::get('/projetos','Site\InstitucionalController@projetos'); 
Route::get('/projetos/{id}/selecionado','Site\InstitucionalController@pselec')->name('projeto.selecionado'); 

Route::get('/noticias','Site\InstitucionalController@noticias');
Route::get('/noticias/{id}/selecionada','InstitucionalController@noticiasselec')->name('noti');   

Route::get('/contato','Site\InstitucionalController@contato');   
Route::get('/infantil','Site\InstitucionalController@infantil');   
Route::get('/fundamental','Site\InstitucionalController@fundamental'); 
Route::get('/medio','Site\InstitucionalController@medio');

Route::post('/envia_email','ContatoController@envia')->name('contato.email');

#####################################################################################################
// FIM DAS ROTAS PARA SITE INSTITUCIONAL

// INICIO DAS ROTAS PARA SITE O CARRINHO
#####################################################################################################
Route::get('/', 'Site\LojaController@index')->name('site.home');
Route::get('paginas/{id}', 'Site\LojaController@pagina')->name('loja.pagina.index');
Route::get('remove-cart/{id}', 'Site\CarrinhoController@remove')->name('remove.cart');
Route::post('add-cart/{id}', 'Site\CarrinhoController@addCartDetalhes')->name('add.cart.detalhes');
Route::get('add-cart/{id}', 'Site\CarrinhoController@add')->name('add.cart');

Route::get('carrinho', 'Site\CarrinhoController@carrinho')->name('carrinho');
Route::post('pagamento', 'Site\CarrinhoController@statusPagamento')->name('paga.tokenizer.mercadopago');
Route::post('pagamento/transferencia', 'Site\CarrinhoController@pagamentoTransferencia')->name('paga.transferencia');

Route::post('frete/{id?}', 'Site\CarrinhoController@calculoFrete')->name('calculo.frete.detalhes');
Route::post('subtotal', 'Site\CarrinhoController@subtotalcart')->name('subtotalcart.cart');
Route::post('guardacep/{id?}', 'Site\CarrinhoController@guardaCep')->name('guardacep.cart');

Route::post('produto/{id}/detalhes', 'Site\CarrinhoController@calculoFreteDetalhe')->name('cep.detalhe');
Route::get('produto/{nome}/{id}/detalhes', 'Site\LojaController@detalhesProduto')->name('produto.detalhes');
Route::any('/produtos/filtrados', 'Site\LojaController@filtro')->name('loja.pesquisa');

#####################################################################################################
// FIM DAS ROTAS PARA SITE CARRINHO


// INICIO DAS ROTAS PARA ÁREA ADMINISTRATIVA CLIENTE
#####################################################################################################
Route::get('/cliente/register', 'Site\ClienteSiteController@register')->name('cliente.regiter');
Route::post('/cliente/save/', 'Site\ClienteSiteController@save')->name('cliente.save');
Route::get('/cliente/dados/iniciais/cad', 'Site\ClienteSiteController@indexCadastro')->name('cliente.index.cadastro');
Route::get('/cliente/dados/iniciais/log', 'Site\ClienteSiteController@indexLogin')->name('cliente.index.login');
Route::get('/cliente/dados', 'Site\ClienteSiteController@login')->name('cliente.login');
Route::post('/cliente/autentica', 'Site\ClienteSiteController@autoriza')->name('cliente.autentica');
Route::get('/cliente/logout', 'Site\ClienteSiteController@clienteLogout')->name('cliente.logout');
Route::get('/cliente/pedidos', 'Site\ClienteSiteController@pedidos')->name('cliente.pedidos');


// FIM DAS ROTAS PARA ÁREA ADMINISTRATIVA CLIENTE
#####################################################################################################

