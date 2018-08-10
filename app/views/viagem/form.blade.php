@extends('template.layout')
@section('title','Formulário')

@section('content')

<div class="card">
    <div class="card-header"><h4>Formulário para solicitar autorização de veículos</h4></div>
    <div class="card-body">
        <h4 class="section-title">Forma de organização da viagem</h4>
        <div class="form-group text-center">
            @foreach($data['organizacoes'] as $key=>$organizacao)
            <div class="custom-control custom-radio custom-control-inline">
                <?= Form::radio('organizacao_id', $organizacao->id, (isset($viagem) && $viagem->organizacao_id) || (!isset($viagem)&& $key==0) == $organizacao->id ? true : false,array('class' => 'custom-control-input', 'id'=>"tipo_$organizacao->id")) ?>
                <label class="custom-control-label" for="tipo_{{$organizacao->id}}">{{$organizacao->nome}}</label>
            </div>
            @endforeach
        </div>
        <h4 class="section-title">Responsável pela organização da viagem</h4>
        <?= Form::open(array('url' => $data['url'], 'method' => $data['method'],'data-viagem_id'=> $data['id'], 'id' => 'form', 'files' => true));?>
        <div class="row">
            <div class="form-group col-md-12">
                <label>Nome <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-user"></span>
                        </span>
                    </div>
                    <?= Form::text('pessoa[nome]', isset($viagem)? $viagem->pessoa->nome : null, array('class' => 'form-control required', 'placeholder' => 'Nome'))?>
                </div>
                <?= $errors->first('pessoa.nome') ?>
            </div>

            <div class="form-group col-md-6">
                <label>CPF <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-address-card"></span>
                        </span>
                    </div>
                    <?= Form::text('pessoa[cpf]', isset($viagem)? $viagem->pessoa->cpf : null, array('class' => 'form-control required cpf', 'placeholder' => 'CPF'))?>
                </div>
                <?= $errors->first('pessoa.cpf') ?>
            </div>

            <div class="form-group col-md-6">
                <label>E-mail <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-at"></span>
                        </span>
                    </div>
                    <?= Form::text('contato[email]', isset($viagem)? $viagem->pessoa->contato->email : null, array('class' => 'form-control required telefone_numero', 'placeholder' => 'E-mail'))?>
                </div>
                <?= $errors->first('contato.email') ?>
            </div>

            <div class="form-group col-md-6">
                <label>Telefone <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </span>
                    </div>
                    <?= Form::text('contato[telefone]', isset($viagem)? $viagem->pessoa->contato->telefone : null, array('class' => 'form-control required telefone_numero', 'placeholder' => 'Telefone'))?>
                </div>
                <?= $errors->first('contato.telefone') ?>
            </div>

            <div class="form-group col-md-6">
                <label>Celular <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-mobile-alt"></span>
                        </span>
                    </div>
                    <?= Form::text('contato[celular]', isset($viagem)? $viagem->pessoa->contato->celular : null, array('class' => 'form-control required telefone_numero', 'placeholder' => 'Celular'))?>
                </div>
                <?= $errors->first('contato.celular') ?>
            </div>

        </div>
        
        <h4 class="section-title">Visitantes</h4>

        <div class="row">

            <div class="form-group col-md-5">
                <label>Estado <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-map"></span>
                        </span>
                    </div>
                    <?= Form::select('estado', $data['estados'],isset($viagem)? isset($viagem->pessoa->endereco->cidade_id)?$data['select']['estado']->id:null :35,array('class'=>'form-control required estado','id'=>'estado','aria-required'=>"true"))?>
                </div>
                <?= $errors->first('estado'); ?>
            </div>

            <div class="form-group col-md-7">
                <label>Cidade <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-map-marker-alt"></span>
                        </span>
                    </div>
                    <?= Form::select('cidade_origem', $data['cidades'],isset($viagem)? isset($viagem->pessoa->endereco->cidade_id)?$data['select']['cidade']->id :null :3388,array('class'=>'form-control required cidade_id','id'=>'cidade_id','aria-required'=>"true"))?>
                </div>
                <?= $errors->first('cidade_origem'); ?>
            </div>

            <div class="form-group col-md-4">
                <label>Número de pessoas <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-users"></span>
                        </span>
                    </div>
                    <?= Form::text('numeroPessoas', isset($viagem)? $viagem->numeroPessoas : null, array('class' => 'form-control required', 'placeholder' => 'Número de pessoas'))?>
                </div>
                <?= $errors->first('numeroPessoas') ?>
            </div>
            
            <div class="form-group col-md-4">
                <label>Data de chegada <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-calendar-alt"></span>
                        </span>
                    </div>
                    <?= Form::text('chegada', isset($viagem)? $viagem->chegada : null, array('class' => 'form-control required data', 'placeholder' => 'Data de chegada'))?>
                </div>
                <?= $errors->first('chegada') ?>
            </div>

            <div class="form-group col-md-4">
                <label>Data de saída <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-calendar-alt"></span>
                        </span>
                    </div>
                    <?= Form::text('saida', isset($viagem)? $viagem->saida : null, array('class' => 'form-control required data', 'placeholder' => 'Data de saida'))?>
                </div>
                <?= $errors->first('saida') ?>
            </div>

        </div>

        <h4 class="section-title">Em caso da viagem ser organizada por agência ou empresa de ônibus</h4>
        <div class="row">
            <div class="form-group col-md-12">
                <label>Nome da empresa <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-building"></span>
                        </span>
                    </div>
                    <?= Form::text('empresa[nome]', isset($viagem)? $viagem->empresa->nome : null, array('class' => 'form-control required', 'placeholder' => 'Nome'))?>
                </div>
                <?= $errors->first('empresa.nome') ?>
            </div>
            <div class="form-group col-md-6">
                <label>E-mail <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-at"></span>
                        </span>
                    </div>
                    <?= Form::text('empresa[contato][email]', isset($viagem)? $viagem->empresa->contato->email : null, array('class' => 'form-control required', 'placeholder' => 'E-mail'))?>
                </div>
                <?= $errors->first('empresa.contato.email') ?>
            </div>

            <div class="form-group col-md-6">
                <label>Telefone <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </span>
                    </div>
                    <?= Form::text('empresa[contato][telefone]', isset($viagem)? $viagem->empresa->contato->telefone : null, array('class' => 'form-control required telefone_numero', 'placeholder' => 'Telefone'))?>
                </div>
                <?= $errors->first('empresa.contato.telefone') ?>
            </div>

            <div class="form-group col-md-6">
                <label>Fax <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-fax"></span>
                        </span>
                    </div>
                    <?= Form::text('empresa[contato][fax]', isset($viagem)? $viagem->empresa->contato->celular : null, array('class' => 'form-control required telefone_numero', 'placeholder' => 'Fax'))?>
                </div>
                <?= $errors->first('empresa.contato.celular') ?>
            </div>
            <div class="form-group col-md-6">
                <label>Site <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-desktop"></span>
                        </span>
                    </div>
                    <?= Form::text('empresa[site]', isset($viagem)? $viagem->empresa->site : null, array('class' => 'form-control required', 'placeholder' => 'Site'))?>
                </div>
                <?= $errors->first('empresa.site') ?>
            </div>
        </div>

        <h4 class="section-title">Tipo do(s) veículo(s)</h4>
        <div class="row">
            <div class="form-group col-md-12">
                <label>Nome da empresa do veículo <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-building"></span>
                        </span>
                    </div>
                    <?= Form::text('empresa_veiculo', isset($viagem)? $viagem->empresa->empresa_veiculo : null, array('class' => 'form-control required', 'placeholder' => 'Nome da empresa do veículo'))?>
                </div>
                <?= $errors->first('empresa_veiculo') ?>
            </div>        
        </div>

        <h4 class="section-title">Dados gerais</h4>
        <div class="row">
            <div class="form-group col-md-6">
                <label>Perfil do visitante <span>*</span></label>
                <div class="input-group recontar">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <span class="fas fa-list"></span>
                    </span>
                    </div>
                    <?= Form::select('estado', $data['estados'],isset($usuario)? isset($usuario->individuo->endereco->cidade_id)?$data['select']['estado']->id:null :35,array('class'=>'form-control required estado selectpicker','id'=>'estado','aria-required'=>"true", 'multiple'))?>
                </div>
            <?= $errors->first('estado'); ?>
            </div>
        </div>      


        <?= Form::submit(isset($viagem)?'Atualizar':'Cadastrar', array('class' => 'btn btn-success btn-block'));?>
        <?= Form::close() ?>
    </div>
</div>

@stop

@section('js')

@stop