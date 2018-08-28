@extends('template.layout')
@section('title','Turismo')

@section('content')

<div class="card">
    <div class="card-header"><h4>Viagem - {{$viagem->chegada}}</h4>
        <ul class="nav nav-tabs nav-justified card-header-tabs">
			<li class="nav-item">
				<a data-toggle="tab" id="informacoes-tab" href="#informacoes" role="tab" aria-controls="informacoes" aria-selected="true" class="nav-link active">Informações</a>
			</li>
			<li class="nav-item">
				<a data-toggle="tab" id="acoes-tab" role="tab" aria-controls="acoes" aria-selected="false" class="nav-link" href="#acoes">Ações</a>
			</li>
		</ul>
    </div>
    <div class="card-body tab-content">
        <div id="informacoes" role="tabpanel" aria-labelledby="informacoes-tab" class="tab-pane fade active show">
            <h4 class="section-title">Responsável pela organização da viagem</h4>
            <div class="row col-md-12">
                <div class="form-group col-sm-6">
                    <label ><strong>Nome</strong></label>
                    <p class="card-text">{{$viagem->pessoa->nome}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>CPF</strong></label>
                    <p class="card-text">{{$viagem->pessoa->cpf}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>E-mail</strong></label>
                    <p class="card-text">{{$viagem->pessoa->contato->email}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Telefone</strong></label>
                    <p class="card-text">{{$viagem->pessoa->contato->telefone}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Celular</strong></label>
                    <p class="card-text">{{$viagem->pessoa->contato->celular}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Documento</strong></label>
                    <div class="input-group">
                        <span class="form-control">{{$viagem->pessoa->anexo}}</span>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <a class="fa fa-download" title="Download do arquivo" href='{{ url ("download/pessoas/".$viagem->pessoa->anexo)}}'> Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="section-title">Visitantes</h4>
            <div class="row col-md-12">
                <div class="form-group col-sm-6">
                    <label ><strong>Estado</strong></label>
                    <p class="card-text">{{$viagem->cidade->estado->nome}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Cidade</strong></label>
                    <p class="card-text">{{$viagem->cidade->nome}}</p>
                </div>
                <div class="form-group col-sm-4">
                    <label ><strong>Número de pessoas</strong></label>
                    <p class="card-text">{{$viagem->numeroPessoas}}</p>
                </div>
                <div class="form-group col-sm-4">
                    <label ><strong>Data de chegada</strong></label>
                    <p class="card-text">{{$viagem->chegada}}</p>
                </div>
                <div class="form-group col-sm-4">
                    <label ><strong>Data de saída</strong></label>
                    <p class="card-text">{{$viagem->saida}}</p>
                </div>
            </div>
            @if($viagem->organizacao_id == 1)
            <h4 class="section-title">Organização da viagem</h4>
            <div class="row col-md-12">
                <div class="form-group col-sm-6">
                    <label ><strong>Nome da empresa</strong></label>
                    <p class="card-text">{{$viagem->empresa->nome}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>E-mail</strong></label>
                    <p class="card-text">{{$viagem->empresa->contato->email}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Telefone</strong></label>
                    <p class="card-text">{{$viagem->empresa->contato->email}}</p>
                </div>
                @if($viagem->empresa->site)
                <div class="form-group col-sm-6">
                    <label ><strong>Site</strong></label>
                    <p class="card-text">{{$viagem->empresa->site}}</p>
                </div>
                @endif
                <div class="form-group col-sm-6">
                    <label ><strong>Estado</strong></label>
                    <p class="card-text">{{$viagem->empresa->cidade->estado->nome}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Cidade</strong></label>
                    <p class="card-text">{{$viagem->empresa->cidade->nome}}</p>
                </div>
            </div>
            @endif

            <h4 class="section-title">Dados gerais</h4>
            <div class="row col-md-12">
                <div class="form-group col-sm-6">
                    <label ><strong>Primeira vez no município?</strong></label>
                    <p class="card-text">{{$viagem->primeira_vez ? "Sim" : "Não - ".$viagem->quantidadeVez->nome}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Perfil do visitante</strong></label>
                    <p class="card-text">{{$viagem->getVisitantes()}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Destino</strong></label>
                    <p class="card-text">{{$viagem->getDestinos()}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Nome do local/ Endereço</strong></label>
                    <p class="card-text">{{$viagem->local_destino}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Bairro</strong></label>
                    <p class="card-text">{{$viagem->bairro->nome}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Local para refeições</strong></label>
                    <p class="card-text">{{$viagem->getRefeicoes()}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Motivo da viagem</strong></label>
                    <p class="card-text">{{$viagem->getMotivos()}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Atrativo principal</strong></label>
                    <p class="card-text">{{$viagem->getAtrativos()}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Tem roteiro pré-definido?</strong></label>
                    <p class="card-text">{{$viagem->roteiro_predefinido ? "Sim - ".$viagem->roteiro_especificar : "Não"}}</p>
                </div>
                @if($viagem->sugestao)
                <div class="form-group col-sm-6">
                    <label ><strong>Sugestões e reclamações</strong></label>
                    <p class="card-text">{{$viagem->sugestao}}</p>
                </div>
                @endif
            </div>

            <h4 class="section-title">Veículos</h4>
            <table class="table table-bordered" id="veiculotable">
                <thead>
                    <th>Tipo do veículo</th>
                    <th>Placa do veículo</th>
                    <th>Registro EMBRATUR</th>
                    <th>Arquivos</th>
                </thead>
                <tbody>
                    @foreach($viagem->veiculos as $veiculo)
                    <tr>
                        <td>{{$veiculo->tipo->nome}}</td>
                        <td>{{$veiculo->placa}}</td>
                        <td>{{$veiculo->registro}}</td>
                        <td><a title="Download do arquivo" href='{{ url ("download/veiculos/".$veiculo->anexo)}}'><div class="input-group-text">
                            <span class="fa fa-download" > Download</span>
                        </div></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        
        </div>
        <div id="acoes" role="tabpanel" aria-labelledby="acoes-tab" class="tab-pane fade">
            <h4 class="section-title">Responder pedido de autorização</h4>
            <?= Form::open(array('url' => 'viagem/responder', 'method' => 'POST', 'files' => true,'id' => "form"));?>
            <div class="row col-md-12">
                <div class="form-group col-md-12">
                    <label>Arquivo para o solicitante </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-folder-open" aria-hidden="true"></span>
                            </span>
                        </div>
                        <?= Form::file('anexo', array('style' => 'opacity: 1;','class' => 'form-control required', 'id' => 'anexo')) ?>
                    </div>
                    <?= $errors->first('anexo') ?>
                </div>
                <div class="form-group col-md-12">
                    <label>Texto <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-align-justify"></span>
                            </span>
                        </div>
                        <?= Form::textarea('texto', null, array('class' => 'form-control', 'placeholder' => 'Digite aqui suas reclamações e sugestões', 'rows' => 5))?>
                    </div>
                    <?= $errors->first('texto') ?>
                </div>
            </div>    
            <?= Form::submit('Responder', array('class' => 'btn btn-outline-success btn-block'));?>
            <?= Form::close() ?>

            <h4 class="section-title">Finalizar pedido de autorização</h4>
            <?= Form::open(array('url' => 'viagem/finalizar', 'method' => 'POST', 'files' => true,'id' => "form"));?>
            <div class="row col-md-12">
                <div class="form-group col-md-12">
                    <label>Arquivo para o solicitante </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-folder-open" aria-hidden="true"></span>
                            </span>
                        </div>
                        <?= Form::file('anexo', array('style' => 'opacity: 1;','class' => 'form-control required', 'id' => 'anexo')) ?>
                    </div>
                    <?= $errors->first('anexo') ?>
                </div>
                <div class="form-group col-md-12">
                    <label>Texto <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-align-justify"></span>
                            </span>
                        </div>
                        <?= Form::textarea('texto', null, array('class' => 'form-control', 'placeholder' => 'Digite aqui suas reclamações e sugestões', 'rows' => 5))?>
                    </div>
                    <?= $errors->first('texto') ?>
                </div>
            </div>    
            <?= Form::submit('Finalizar', array('class' => 'btn btn-outline-success btn-block'));?>
            <?= Form::close() ?>
        </div>
    </div>
</div>
@stop