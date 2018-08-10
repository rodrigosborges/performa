<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>E-Licitações</title>

        <link rel="stylesheet" media="all" href="{{asset('assets/css/reset.css')}}">
        <link rel="stylesheet" media="all" href="{{asset('assets/css/relatorio.css')}}">
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
        <script src="{{ asset('assets/js/jquery-3.1.1.min.js') }}"></script>
        @yield('css')

        <style>
            b{ font-weight: bold !important }

            .topico{
                border-bottom: solid 1px black;
                font-size: 20px;
                margin-top: 15px;
            }
	    </style>

    </head>
    <body>

        <header id="header" class="header col-xs-10">
            <div class="row" style="vertical-align: middle">
                <img class="imagem" src="{{ asset('assets/img/Prefeitura-1.jpg') }}" alt="">
                <div class="print-line"><b>PREFEITURA MUNICIPAL DA ESTÂNCIA BALNEÁRIA DE CARAGUATATUBA</b></div>
                <div class="print-line"><b>SISTEMA E-LICITAÇÕES</b></div>
            </div>
        </header>
        @yield('footer')
        <div class="body" style="margin-top: -40px;">
            @yield('content')
        </div>


    <script type="text/javascript">


        window.print();

        setTimeout(function(){
            $(window).one('mousemove', window.onafterprint);
        }, 1);


    </script>

    </body>
</html>