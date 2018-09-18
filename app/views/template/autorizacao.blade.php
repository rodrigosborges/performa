<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Autorização</title>

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

            .titulo{
                margin-top: 50px;
                margin-bottom: 15px;
            }

            .caraguatatuba{
                display: inline-block; 
                vertical-align: middle;
            }

            footer{
                position: fixed; 
                bottom: 0px; 
                left: 60px; 
                right: 60px; 
                height: 100px;
            }

            .assinatura{
                width: 180px;
                height:120px;
            }
            
            .subtitles{
                font-size: 18 !important;
            }

            .values{
                font-size: 65 !important;
            }
            
	    </style>

    </head>
    <body>

        <header id="header" class="header col-xs-10">
            <div class="row" style="vertical-align: middle">
                <div class="print-line titulo"><b style="font-size:20 !important;">AUTORIZAÇÃO PARA PERMANÊNCIA DE VEÍCULO EM CARAGUATATUBA</b></div>
                <div style="caraguatatuba">
                    <img class="imagem" src="{{ asset('assets/img/logo-preto.jpg') }}" alt="">
                    <b style="font-size:50 !important;"> CARAGUATATUBA/SP</b>
                </div>
            </div>
        </header>
        <div class="body">
            @yield('content')
        </div>
        <footer>
            <div style="width: 60%; text-align:center;display: inline-block">
                <b>ESTE VEÍCULO DEVERÁ PERMANECER NO ESTACIONAMENTO DO DESTINO, 
                ONDE O NÃO ANTEDIMENTO ACARRETARÁ EM MULTA E APREENSÃO DO VEICULO.</b>
            </div>

            <div style="width: 40%; text-align:center;display: inline-block;">
                <div style="padding-top: -60px;"><img class="assinatura" src="{{ asset('assets/img/assinatura.png') }}" alt=""></div>
                <div><b>SECRETARIA DE TURISMO</b></div>
            </div>
        </footer>

    </body>
</html>