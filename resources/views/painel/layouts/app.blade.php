<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta https-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>SUPERMIDIA</title>

    <link rel="stylesheet" type="text/css" href="/assets/painel/stylesheets/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/painel/stylesheets/algaworks.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/painel/stylesheets/application.css" />
    <link rel="stylesheet" type="text/css" src="{{url('/node_modules/spinkit/css/spinkit.css')}}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


    <style type="text/css">
        .spinner {
            width: 40px;
            height: 40px;
            background-color: #FFFFFF;
            position: absolute;
            top: 48%;
            left: 48%;
            -webkit-animation: sk-rotateplane 1.2s infinite ease-in-out;
            animation: sk-rotateplane 1.2s infinite ease-in-out;
        }

        @-webkit-keyframes sk-rotateplane {
            0% {
                -webkit-transform: perspective(120px)
            }

            50% {
                -webkit-transform: perspective(120px) rotateY(180deg)
            }

            100% {
                -webkit-transform: perspective(120px) rotateY(180deg) rotateX(180deg)
            }
        }

        @keyframes sk-rotateplane {
            0% {
                transform: perspective(120px) rotateX(0deg) rotateY(0deg);
                -webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg)
            }

            50% {
                transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
                -webkit-transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg)
            }

            100% {
                transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
                -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
            }
        }

        .spinner-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #123456;
            z-index: 999999;
        }
    </style>

</head>

@section('menu')
<div class="aw-layout-loading  js-loading-overlay">
    <div class="aw-layout-loading__container">
        <span class="aw-balls-spinner">Carregando...</span>
    </div>
</div>

<div class="aw-layout-page">

    <nav class="navbar  navbar-fixed-top  navbar-default  js-sticky-reference" id="main-navbar">
        <div class="container-fluid">

            <div class="navbar-header">
                {{-- <a class="navbar-brand  hidden-xs" href="{{route('home')}}">
                    <img alt="Lsystems" src="/assets/painel/images/logo.png" width="65px" style="background-color:#343638; margin: 0px; padding: 5px; border-radius: 5px; margin-top: -3px;">
                </a> --}}

                <ul class="nav  navbar-nav">
                    <li>
                        <a href="#" class="js-sidebar-toggle"><i class="fa  fa-bars"></i></a>
                    </li>
                </ul>
            </div>

            <ul class="nav navbar-nav  navbar-right">

                {{-- <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa  fa-envelope"></i> <span class="label  label-danger  aw-label-corner">48</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="javascript:;">Item 1</a></li>
                        <li><a href="javascript:;">Item 2</a></li>
                    </ul>
                </li> --}}

                <li>
                    <a target="__blank" href="https://www.smvisual.com.br" title="Ver no site"><i class="fa fa-external-link-square" aria-hidden="true"></i></a>
                </li>
                {{--
                <li class="dropdown">
                    <a href="{{route('usuarios.todos')}}" class="dropdown-toggle" data-toggle="dropdown" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa  fa-user"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <div class="aw-logged-user">
                                <img src="https://api.adorable.io/avatars/80/joaodascouves" width="80" height="80" alt="João das Couves"
                                    class="aw-logged-user__picture" />
                                <span class="aw-logged-user__name">João das Couves</span>
                            </div>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Meu perfil</a></li>
                        <li><a href="#">Alterar senha</a></li>
                        <li><a href="#">Pagamentos</a></li>
                    </ul> --}}
                </li>

                <li>
                    <a href="{{route('logout')}}" title="Sair"><em class="fa  fa-sign-out"></em></a>
                </li>
            </ul>

        </div>
    </nav>

    <aside class="aw-layout-sidebar  js-sidebar">
        <div class="aw-layout-sidebar__content">

            <nav class="aw-menu  js-menu">
                <ul class="aw-menu__list">

                    <li class="aw-menu__item">
                        <a href="{{route('home')}}"><i class="fa  fa-fw  fa-home"></i><span>Dashboard</span></a>
                    </li>

                    <li class="aw-menu__item is-active">
                        <a href="#">
                            <i class="fa fa-lock" aria-hidden="true"></i></i><span>Usuários e Permissões</span>
                            <i class="aw-menu__navigation-icon  fa"></i>
                        </a>

                        <ul class="aw-menu__list  aw-menu__list--sublist">
                            <li class="aw-menu__item  aw-menu__item--link"><a href="{{route('usuarios.todos')}}">
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                    Gestão de Usuários</a>
                            </li>
                        </ul>
                        <ul class="aw-menu__list  aw-menu__list--sublist">
                                <li class="aw-menu__item  aw-menu__item--link"><a href="{{route('usuarios.todos')}}">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                        Gestão de Perfis</a>
                                </li>
                        </ul>
                        <ul class="aw-menu__list  aw-menu__list--sublist">
                                <li class="aw-menu__item  aw-menu__item--link"><a href="{{route('usuarios.todos')}}">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                        Gestão de permissões</a>
                                </li>
                        </ul>
                    </li>
                    <li class="aw-menu__item is-active">
                        <a href="#">
                            <i class="fa fa-file-image-o" aria-hidden="true"></i><span>Categorias</span>
                            <i class="aw-menu__navigation-icon  fa"></i>
                        </a>

                        <ul class="aw-menu__list  aw-menu__list--sublist">
                            <li class="aw-menu__item  aw-menu__item--link"><a href="{{route('categoria.index')}}">
                                    <i class="fa fa-object-group" aria-hidden="true">
                                    </i>Gestão de categorias</a>
                            </li>
                        </ul>
                    </li>

                    <li class="aw-menu__item is-active">
                        <a href="#">
                            <i class="fa fa-file" aria-hidden="true"></i><span>Páginas</span>
                            <i class="aw-menu__navigation-icon  fa"></i>
                        </a>
                        <ul class="aw-menu__list  aw-menu__list--sublist">
                                <li class="aw-menu__item  aw-menu__item--link"><a href="{{route('pagina.index')}}">
                                        <i class="fa fa-object-group" aria-hidden="true">
                                        </i>Páginas produtos</a>
                                </li>
                        </ul>
                        <ul class="aw-menu__list  aw-menu__list--sublist">
                                <li class="aw-menu__item  aw-menu__item--link"><a href="{{route('webbanners')}}">
                                        <i class="fa fa-object-group" aria-hidden="true">
                                        </i>Páginas WebBanner</a>
                                </li>
                        </ul>

                    </li>
                    <li class="aw-menu__item is-active">
                            <a href="#">
                                <i class="fa fa-product-hunt" aria-hidden="true"></i><span>Produtos</span>
                                <i class="aw-menu__navigation-icon  fa"></i>
                            </a>

                            <ul class="aw-menu__list  aw-menu__list--sublist">
    
                                <li class="aw-menu__item  aw-menu__item--link">
                                    <a href="{{route('moldura.index')}}">
                                            <i class="fa fa-window-maximize" aria-hidden="true"></i>Molduras</a>
                                </li>
                            </ul>
    
                            <ul class="aw-menu__list  aw-menu__list--sublist">
    
                                <li class="aw-menu__item  aw-menu__item--link">
                                    <a href="{{route('produto.index')}}">
                                            <i class="fa fa-product-hunt" aria-hidden="true"></i>Gestão de produtos</a>
                                </li>
                            </ul>
                        </li>
                        <li class="aw-menu__item is-active">
                                <a href="#">
                                        <i class="fa fa-flag" aria-hidden="true"></i><span>Gestão de Pedidos</span>
                                    <i class="aw-menu__navigation-icon  fa"></i>
                                </a>
        
                                <ul class="aw-menu__list  aw-menu__list--sublist">
        
                                    <li class="aw-menu__item  aw-menu__item--link">
                                        <a href="{{route('pedidos.index')}}">
                                            <i class="fa fa-flag" aria-hidden="true"></i>Gestão de pedidos</a>
                                    </li>
                                </ul>
                        </li>

                        <li class="aw-menu__item is-active">
                            <a href="{{route('cliente.index')}}">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i><span>Gestão de Clientes</span>
                                    <i class="aw-menu__navigation-icon  fa"></i>
                                </a>
                        </li>
                        
                    {{-- <li class="aw-menu__item is-active">
                        <a href="#">
                            <i class="fa fa-comment" aria-hidden="true"></i></i><span>Solicitação de clientes</span>
                            <i class="aw-menu__navigation-icon  fa"></i>
                        </a>
                    </li> --}}

                </ul>
            </nav>

        </div>
    </aside>

    @show

    @yield('content')

    @section('footer')
    <footer class="aw-layout-footer  js-content">
        <div class="container-fluid">
            <a target="__blank" href="https://feitoporandre.com"><span class="aw-footer-disclaimer">&copy; Desenvolvido
                    por André Martins.</span></a>
        </div>
    </footer>

</div>

<div class="aw-search-modal  js-search-modal">
    <form action="#" class="aw-search-modal__form">
        <input class="aw-search-modal__input  js-search-modal-input" type="text" placeholder="O que você está procurando?" />
        <div class="aw-search-modal__input-icon">
            <i class="glyphicon  glyphicon-search  js-search-modal-go"></i>
        </div>
    </form>

    <div class="aw-search-modal__controls">
        <i class="glyphicon glyphicon-remove  js-search-modal-close"></i>
    </div>
</div>
</div>
@show
<script src="{{url('assets/painel/javascripts/vendors.js')}}"></script>
<script src="/assets/js/jquery.mask.js"></script>
<script src="{{url('assets/painel/javascripts/algaworks.js')}}"></script>
<!-- include summernote css/js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
<script>
    $(function () {
        $('#myForm').submit(function () {
            $('.spinner-wrapper').show();
            return true;
        });
    });
</script>

<script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
</script>

<script>
function add_fields() {
    document.getElementById('wrapper').innerHTML += '<span>altura: <input type="text" style="width:48px;" namae="length[]" value="" /><small>(ft)</small></span><span>altura: <input type="text" style="width:48px;" namae="length[]" value="" /><small>(ft)</small></span>/n/r';
}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#preco').mask('000.000.000.000.000,00', {reverse: true});
    });
 

</script>

</body>


</html>