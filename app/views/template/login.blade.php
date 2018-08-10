<html>
<head>
  <noscript><meta http-equiv="refresh" content="1; URL={{url('erro')}}"/></noscript>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Licitações</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link href="{{asset('assets/css/fontawesome-all.min.css')}}" rel="stylesheet">
  <link rel="icon" type= "image/png" href="{{ asset('assets/img/favicon.png') }}" />
</head>
<body>
  <div class="container-fluid">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 mt-5">
      <div class="card mt-5">
        <div class="card-header"><h2 class="text-center">LICITAÇÕES</h2></div>
        <div class="card-body">
          @include('includes.alerts')
          @yield('content')            
        </div>
      </div>        
    </div>
  </div>
  <script type="text/javascript" src="{{ asset('assets/js/bibliotecas/jquery/jquery-3.2.1.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('assets/js/bibliotecas/jquery/validator/jquery.validate.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('assets/js/bibliotecas/jquery/validator/localization/messages_pt_BR.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('assets/js/bibliotecas/jquery/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/bibliotecas/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/validacao/validate-methods.js')}}"></script>
  <script src="{{ asset('assets/js/bibliotecas/jquery/chosen.jquery.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
  <script type="text/javascript">const main_url = '{{url('/')}}/';</script>
  <script type="text/javascript">
    $(document).ready(function(){
      $('form').validate({
        rules:{
          password:{        
            regex: "^(?=(?:.*[a-zA-z]{1,}))(?=(?:.*[0-9]){1,})(?=(?:.*[!@#$%&*]){1,})(.{10,})$",
          },
          password_confirmation:{       
            equalTo : "input[name='password']"
          },
        },
        messages:{
          password: {
            regex: 'Necessário mínimo 10 caracteres contendo letras, números e caracter especial.',
          }
        }
      });
    })
  </script>
  @yield('js')
</body>
</html>
