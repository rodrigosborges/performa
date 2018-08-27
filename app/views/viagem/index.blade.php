@extends('template.layout')
@section('title','Formulário')

@section('content')

<div class="card">
    <div class="card-header"><h4>Viagens</h4></div>
    <div class="card-body">
    <?= Form::open(array('url' => 'pesquisar','id' => 'avancado', 'method' => 'POST')) ?>
		<div class="row">
			<div class="form-group col-md-6 col-sm-6">
				<label>Status</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-list-alt"></span>
						</span>
					</div>
                    <?= Form::select('status_id', ['' => 'Selecione'], Input::get('status_id'), array('class' => 'form-control chosen-select','id' => 'status')) ?>
				</div>
			</div>
			<div class="form-group col-md-6 col-sm-6">
				<label>Área</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-list-alt"></span>
						</span>
					</div>
					<?= Form::select('area_id', ['' => 'Selecione'], null, array('class' => 'form-control chosen-select', 'id' => 'area')) ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-6">
				<label>Nome do solicitante</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">
							<span class="fas fa-pencil-alt"></span>
						</span>
					</div>
					<?= Form::text('numero', isset($input['licitacao'])? $input['licitacao'] : null, array('class' => 'form-control', 'placeholder' => 'Nome do solicitante')) ?>
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
					<?= Form::text('processo', null, array('class' => 'form-control cpf', 'placeholder' => '999.999.999-99')) ?>
				</div>
			</div>
		</div>

		<?= Form::submit('Pesquisar', array('class' => 'btn btn-success btn-lg btn-block', 'id' => 'enviaform')) ?>
		<?= Form::close() ?>
		<div id="resultados"></div>
    </div>
</div>

@stop

@section('js')
@stop