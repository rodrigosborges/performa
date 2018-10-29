@extends('template.layout')
@section('title','Formulário')

@section('content')

<div class="card">
    <div class="card-header"><h4>Alunos</h4></div>
    <div class="card-body tab-content">
    <?= Form::open(array('url' => 'pesquisar','id' => 'form', 'method' => 'POST')) ?>
		<div class="row">
			<div class="form-group col-md-4">
				<label>Nome do aluno</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-pencil-alt"></span>
						</span>
					</div>
					<?= Form::text('nome', null, array('class' => 'form-control', 'placeholder' => 'Nome do aluno')) ?>
				</div>
			</div>
			<div class="form-group col-md-4">
				<label>CPF do aluno</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-pencil-alt"></span>
						</span>
					</div>
					<?= Form::text('cpf', null, array('class' => 'form-control cpf', 'placeholder' => '999.999.999-99')) ?>
				</div>
			</div>
			<div class="form-group col-md-4">
				<label>Matrícula</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-pencil-alt"></span>
						</span>
					</div>
					<?= Form::text('matricula', null, array('class' => 'form-control', 'placeholder' => '9999')) ?>
				</div>
			</div>
		</div>

		<?= Form::button('Pesquisar', array('class' => 'btn btn-success btn-lg btn-block', 'id' => 'enviaform')) ?>
		<?= Form::close() ?>
		<ul class="nav nav-tabs nav-justified card-header-tabs">
			<li class="nav-item">
				<a data-toggle="tab" id="ativos-tab" href="#ativos" role="tab" aria-controls="ativos" aria-selected="true" class="nav-link active">Ativos</a>
			</li>
			<li class="nav-item">
				<a data-toggle="tab" id="inativos-tab" role="tab" aria-controls="inativos" aria-selected="false" class="nav-link" href="#inativos">Inativos</a>
			</li>
		</ul>
		<br>
		
		<!-- TAB-CONTENT DE ATIVOS -->    
		<div id="ativos" role="tabpanel" aria-labelledby="ativos-tab" class="tab-pane fade active show">
		</div>

		<!-- TAB-CONTENT DE INATIVOS -->    
		<div id="inativos" role="tabpanel" aria-labelledby="inativos-tab" class="tab-pane fade">
		</div>
    </div>
</div>

@stop

@section('js')

<script type="text/javascript" src="{{asset('assets/js/validacao/pesquisaValidator.js')}}"></script>

<script>
	function pesquisar(){
		listagem(main_url+"aluno/listar/ativos",'ativos','form')
		listagem(main_url+"aluno/listar/inativos",'inativos','form')

		$('#ativos').on('click', 'ul.pagination a', function(e){
			e.preventDefault()
			listagem($(this).attr('href'),'ativos')
		})

		$('#inativos').on('click', 'ul.pagination a', function(e){
			e.preventDefault()
			listagem($(this).attr('href'),'inativos')
		})
	}

	$(document).ready(function(){
		pesquisar()
	})

	$("#enviaform").on('click',function(){
		if($("#form").valid())
			pesquisar()
	})

</script>
@stop