@extends('template.layout')
@section('title','Formulário')

@section('content')

<div class="card">
    <div class="card-header"><h4>Viagens</h4></div>
    <div class="card-body tab-content">
    <?= Form::open(array('url' => 'pesquisar','id' => 'form', 'method' => 'POST')) ?>
		<div class="row">
			<div class="form-group col-md-6">
				<label>Status</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-list-alt"></span>
						</span>
					</div>
                    <?= Form::select('status_id', $data['status'], Input::get('status_id'), array('class' => 'form-control chosen-select','id' => 'status')) ?>
				</div>
			</div>
			
			<div class="form-group col-md-6">
				<label>CPF do solicitante</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-pencil-alt"></span>
						</span>
					</div>
					<?= Form::text('cpf', null, array('class' => 'form-control cpf', 'placeholder' => '999.999.999-99')) ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-12">
				<label>Nome do solicitante</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-pencil-alt"></span>
						</span>
					</div>
					<?= Form::text('nome', null, array('class' => 'form-control', 'placeholder' => 'Nome do solicitante')) ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-4">
				<label>De</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-calendar"></span>
						</span>
					</div>
					<?= Form::text('de', null, array('class' => 'form-control data', 'placeholder' => '00/00/0000')) ?>
				</div>
			</div>
			<div class="form-group col-md-4">
				<label>Até </label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-calendar"></span>
						</span>
					</div>
					<?= Form::text('ate', null, array('class' => 'form-control data', 'placeholder' => '00/00/0000')) ?>
				</div>
			</div>
			<div class="form-group col-md-4">
				<label>Tipo de filtro de data</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-list"></span>
						</span>
					</div>
					<?= Form::select('tipodata', ['1' => 'Cadastro','2' => 'Chegada'], null, array('class' => 'form-control')) ?>
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

<script>
	function pesquisar(){
		listagem(main_url+"viagem/listar/ativos",'ativos','form')
		listagem(main_url+"viagem/listar/inativos",'inativos','form')

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
		pesquisar()
	})

</script>
@stop