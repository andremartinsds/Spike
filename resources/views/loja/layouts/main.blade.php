@inject('webbanners', 'App\WebBanner')
<!DOCTYPE html>
<html>

<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KLL7N84');</script>
    <!-- End Google Tag Manager -->

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
    <title>Pôsteres, quadros e artes visuais | Filtrado por Mais Vendidos</title>
 
    <meta name="description" content="Quadros decorativos super fofos para alegrar suas paredes!"/>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <!--Fonts Icons-->
    <link rel="stylesheet" href="{{url('assets/css/font-awesome.min.css')}}">

    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800" rel="stylesheet">

    <!--Fonts Icons-->
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/reset.css')}}">

    <!--Favicon-->
    <link rel="icon" type="image/png" href="{{url('images/favicon.png')}}">
    
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KLL7N84"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    @section('header')
    <nav class="white navbar navbar-default navbar-fixed-top">
            <nav>
                    <div class="container-fluid">
                            <div class="row">
                                <div class="espaco-logo-botoes">
                                    <div class="col-md-4">
                                        <div>
                                            <a href="/">
                                                <img src="/images/logo.jpg" style="max-width: 211px;">
                                            </a>
                                        </div>
                                  </div>
                                  <div class="espaco-entre-logo-botoes"></div>

                                  <div class="col-md-4">
                                      <form action="{{route('loja.pesquisa')}}">
                                        <div class="input-group">
                                                <input  name="inserido_pelo_usuario" type="text" class="form-control" placeholder="Digite sua busca">
                                                <span class="input-group-btn">
                                                  <button class="btn btn-warning botao-pesquisa" type="submit">
                                                        <i class="fa fa-search-plus" aria-hidden="true"></i>
                                                  </button>
                                                </span>
                                            </div>
                                        </form>
                                  </div>

                                  <div class="espaco-entre-logo-botoes"></div>

                                  <div class="col-md-4 text-right">
                                        <div>
                                            @if( Session::has('carrinho') )
                                            <a href="{{route('carrinho')}}" type="button" class="botao-topo btn btn-warning custom-button-width">
                                                  <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                              </a>
                                              @endif
                                        <a href="{{route('cliente.login')}}" type="button" class="botao-topo btn">
                                              <i class="fa fa-user" aria-hidden="true"></i>
                                        </a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
            </nav>
        <div class="container">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
                        aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        @foreach ($categorias as $categoria)
                        @if($categoria->publicado == true)
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                                aria-expanded="false">
                                {{$categoria->nome}}
                                <span class="caret"></span></a>
                            @if($categoria->publicado == true)
                            <ul class="dropdown-menu">
                                @foreach ($categoria->paginas as $paginas)
                                <li><a href="{{route("loja.pagina.index",$paginas->id)}}">{{$paginas->nome}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @else
                        @endif
                        @else
                        @endif
                        @endforeach

                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </div>
        <!--Container-->
    </nav>
    @show

    @section('webbanner')
    <div class="espaco-antes-web-banner"></div>

    <!-- works -->
    <div id="works" class="container-fluid">
        <div class="row">

            <div class="col-md-12 reset-for-carrousel">

                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    {{-- <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>

                    </ol> --}}

                    <!-- Wrapper for slides -->

                    <div class="carousel-inner" role="listbox">
                        @php
                        $aux = 1;
                        @endphp
                        @foreach ($webbanners->all() as $index => $webbanner)
                        @if($webbanner->publicado == 1)
                        <div class="item @if($aux==1) @php $aux=2; @endphp {{ 'active' }} @endif">
                            <a href="{{ $webbanner->url }}">
                                <img class="my-images-for-carrousel" src="{{'\\assets\\uploads\\webbanners\\'.$webbanner->imagem}}"
                                    alt="{{$webbanner->title}}">
                                <div class="carousel-caption">
                                </div>
                            </a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>



            </div>

        </div>
    </div>
    <div class="espaco-antes-compra-segura"></div>
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-12 text-center">
            <img src="/images/compra_segura.png"/>    
        </div>    
        </div>
    </div>
    </div>

    @show

    <div class="container">
        @yield('content')
    </div>
    <div class="padding-20px"></div>
    <div class="container-fluid ">
        <nav class="navbar navbar-default navbar-fixed-bottom footer">
        <div class="row texto-rodape-cnpj">
            <div class="col-md-12 text-center">
                    <p> COPYRIGHT Supermidia Comunicação visual 22.881.324/0001-19</p>                
                </div>
        </div>
    </nav>
    </div>
           
<a target="_blank" href="https://api.whatsapp.com/send?1=pt_BR&phone=5563984121921">
    <img class="whatsapp" src="/images/wapp.png">
</a>
    <!--jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>

    <script src="/assets/js/jquery.mask.js"></script>
    <script src="/assets/js/jquery.elevatezoom.js"></script>

    <script src="/assets/vendors/js/cycle.min.js"></script>

    <!--Bootstrap-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    
        <script type="text/javascript">
            $(document).ready(function(){
                $('.cep').mask('00000-000');
                $('.cpf').mask('000.000.000-00', {reverse: true});
                $('.phone_with_ddd').mask('(00) 00000-0000');
            });
            function enviaFormInputCorreio() {
                document.getElementById('form1').submit();
            }

            $("#desabilitado").prop('disabled',true);
            $("#desabilitado1").prop('disabled',true);

        </script>
</body>
  
</html>