<html>
<head>
  	<noscript><meta http-equiv="refresh" content="1; URL={{url('erro')}}"/></noscript>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Rodrigo Borges">

	<title>Turismo</title>

	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-dialog.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chosen.min.css') }}">
	<link rel="icon" type= "image/png" href="{{ asset('assets/img/favicon.png') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
	
</head>
<body>
	<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light border-bottom">
		<a class="navbar-brand" href="{{url(Auth::guest() ? '/viagem/create' : '/')}}"><i class="fa fa-home"></i> Turismo</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				
				<li class="nav-item"><a href="{{url('viagem/create')}}" class="nav-link"> Cadastrar </a></li>
				@if(Auth::check())
					@foreach(Status::all() as $status)
						<li class="nav-item"><a href="{{url('viagem?status_id='.$status->id)}}" class="nav-link"> {{$status->nome}} <span class="badge badge-secondary">{{Viagem::where('status_id',$status->id)->count();}}</span></a></li>
					@endforeach
				<li class="nav-item"><a href="{{url('relatorios')}}" class="nav-link"> Relatórios </a></li>
				@endif
				
			</ul>
			<ul class="navbar-nav float-md-left">
				@if(Auth::check())
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<b>{{Auth::user()->usuario}}</b>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{url('reset/password/'.Auth::user()->id)}}">Alterar Senha</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{url('usuario/'.Auth::id().'/edit')}}">Editar</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{url('logout')}}">Sair</a>
					</div>
				</li>
				@endif
			</ul>
		</div>
	</nav>


	<div class="container-fluid mt-5" id="body-content">
		<div class="row">
			<div class="col-sm-10 offset-sm-1 col-md-10 offset-md-1 col-lg-8 offset-lg-2 mt-3">
				@if(!Session::has('modal_show'))
				@include('includes.alerts')
				@endif
				<div class="content-div">
					@yield('content')
				</div>
			</div>			
		</div>
	</div>

	<div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 footer">
		<small>
			<p  class="text-center text-light">
				Desenvolvido por Secretaria de Tecnologia da Informação
			</p>
		</small>
	</div>

	<script type="text/javascript">const main_url = '{{url('/')}}/';</script>
	<script type="text/javascript" src="{{ asset('assets/js/bibliotecas/jquery/jquery-3.2.1.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/bibliotecas/jquery/validator/jquery.validate.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/bibliotecas/jquery/validator/localization/messages_pt_BR.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/bibliotecas/popper.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/bibliotecas/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/bibliotecas/bootstrap-dialog.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/bibliotecas/jquery/jquery.mask.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/validacao/validate-methods.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
	<script src="{{ asset('assets/js/bibliotecas/jquery/chosen.jquery.min.js')}}"></script>
	<script src="{{ asset('assets/js/bibliotecas/jquery/jquery-ui.js')}}"></script>
	<script src="{{ asset('assets/js/bibliotecas/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('assets/js/bibliotecas/defaults-pt_BR.min.js') }}"></script>
	@yield('js')
</body>
</html>
