@extends('template.layout')
@section('title','Formulário')

@section('content')

<div class="card">
    <div class="card-header"><h4>{{$data['title']}}</h4>
    </div>
    <div class="card-body tab-content">
        <div id="informacoes" role="tabpanel" aria-labelledby="informacoes-tab" class="tab-pane fade active show">
            <?= Form::open(array('url' => $data['url'], 'method' => $data['method'],'data-aluno_id'=> $data['id'],'id' => "form"));?>
            <h4 class="section-title">Dados pessoais</h4>
            <div class="row">

                <div class="form-group col-md-12">
                    <label>Nome <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-user"></span>
                            </span>
                        </div>
                        <?= Form::text('nome', isset($aluno)? $aluno->nome : null, array('class' => 'form-control required', 'placeholder' => 'Nome'))?>
                    </div>
                    <?= $errors->first('nome') ?>
                </div>

                <div class="form-group col-md-6">
                    <label>CPF <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-address-card"></span>
                            </span>
                        </div>
                        <?= Form::text('cpf', isset($aluno)? $aluno->cpf : null, array('class' => 'form-control required cpf', 'placeholder' => 'CPF', isset($aluno) ? 'disabled' : ''))?>
                    </div>
                    <?= $errors->first('cpf') ?>
                </div>

                                
                <div class="form-group col-md-6">
                    <label>Data de nascimento <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-calendar-alt"></span>
                            </span>
                        </div>
                        <?= Form::text('data_nascimento', isset($aluno)? $aluno->data_nascimento : null, array('class' => 'form-control required data', 'placeholder' => 'Data de nascimento'))?>
                    </div>
                    <?= $errors->first('data_nascimento') ?>
                </div>

                <div class="form-group col-md-6">
                    <label>Sexo <span>*</span></label>
                    <div class="input-group">
                        <div class="custom-control custom-radio custom-control-inline">
                            <?= Form::radio('sexo', 1, (!isset($aluno) || (isset($aluno) && $aluno->sexo == 1)) ? true : false,array('class' => 'custom-control-input required', 'id'=>"tipo_primeiravez_1")) ?>
                            <label class="custom-control-label" for="tipo_primeiravez_1">Masculino</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <?= Form::radio('sexo', 0, (isset($aluno) && $aluno->sexo == 0) ? true : false,array('class' => 'custom-control-input required', 'id'=>"tipo_primeiravez_0")) ?>
                            <label class="custom-control-label" for="tipo_primeiravez_0">Feminino</label>
                        </div>
                    </div>
                    <?= $errors->first('sexo'); ?>
                </div>

                <div class="form-group col-md-6">
                    <label>Matrícula (caso tenha)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-user"></span>
                            </span>
                        </div>
                        <?= Form::text('matricula', isset($aluno)? $aluno->matricula : null, array('class' => 'form-control', 'placeholder' => 'Matrícula'))?>
                    </div>
                    <?= $errors->first('matricula') ?>
                </div>

                <div class="form-group col-md-6">
                    <label>Plano <span>*</span></label>
                    <div class="input-group recontar">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-list"></span>
                        </span>
                        </div>
                        <?= Form::select('plano_id', $data['planos'], isset($aluno) ? $aluno->plano_id : null,array('class'=>'form-control','aria-required'=>"true" ))?>
                    </div>
                    <?= $errors->first('plano_id'); ?>
                </div>  

                <div class="form-group col-md-6">
                    <label>Dia de pagamento <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-calendar-alt"></span>
                            </span>
                        </div>
                        <?= Form::text('dia_pagamento', isset($aluno)? $aluno->dia_pagamento : null, array('class' => 'form-control required', 'placeholder' => 'Dia de pagamento', 'maxlength' => 2))?>
                    </div>
                    <?= $errors->first('dia_pagamento') ?>
                </div>

            </div>
            
            <h4 class="section-title">Contato</h4>

            <div class="row">

                <div class="form-group col-md-12">
                    <label>E-mail <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-at"></span>
                            </span>
                        </div>
                        <?= Form::text('email', isset($aluno)? $aluno->contato->email : null, array('class' => 'form-control required', 'placeholder' => 'E-mail'))?>
                    </div>
                    <?= $errors->first('email') ?>
                </div>

                <div class="form-group col-md-6">
                    <label>Telefone <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </span>
                        </div>
                        <?= Form::text('telefone', isset($aluno)? $aluno->contato->telefone : null, array('class' => 'form-control required telefone_numero', 'placeholder' => 'Telefone'))?>
                    </div>
                    <?= $errors->first('telefone') ?>
                </div>

                <div class="form-group col-md-6">
                    <label>Celular <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-mobile-alt"></span>
                            </span>
                        </div>
                        <?= Form::text('celular', isset($aluno)? $aluno->contato->celular : null, array('class' => 'form-control required telefone_numero', 'placeholder' => 'Celular'))?>
                    </div>
                    <?= $errors->first('celular') ?>
                </div>
            </div>

            <h4 class="section-title">Endereço</h4>

            <div class="row">
    
                <div class="form-group col-md-12">
                    <label>Endereço <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-road"></span>
                            </span>
                        </div>
                        <?= Form::text('endereco', isset($aluno)? $aluno->endereco->endereco : null, array('class' => 'form-control required', 'placeholder' => 'Endereço'))?>
                    </div>
                    <?= $errors->first('endereco') ?>
                </div>

                <div class="form-group col-md-8">
                    <label>Bairro <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-map-marker"></span>
                            </span>
                        </div>
                        <?= Form::text('bairro', isset($aluno)? $aluno->endereco->bairro : null, array('class' => 'form-control required', 'placeholder' => 'Bairro'))?>
                    </div>
                    <?= $errors->first('bairro') ?>
                </div>

                <div class="form-group col-md-4">
                    <label>CEP <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="far fa-map"></span>
                            </span>
                        </div>
                        <?= Form::text('cep', isset($aluno)? $aluno->endereco->cep : null, array('class' => 'form-control required cep', 'placeholder' => 'CEP'))?>
                    </div>
                    <?= $errors->first('cep') ?>
                </div>

                <div class="form-group col-md-8">
                    <label>Cidade <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-map-marker-alt"></span>
                            </span>
                        </div>
                        <?= Form::text('cidade', isset($aluno)? $aluno->endereco->cidade : (Input::old('cidade') ? null : 'Caraguatatuba'), array('class' => 'form-control required', 'placeholder' => 'Cidade'))?>
                    </div>
                    <?= $errors->first('cidade') ?>
                </div>

                <div class="form-group col-md-4">
                    <label>UF <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-map"></span>
                            </span>
                        </div>
                        <?= Form::select('uf', ['' => 'SELECIONE', 'AC' => 'AC','AL' => 'AL','AM' => 'AM','AP' => 'AP','BA' => 'BA','CE' => 'CE','DF' => 'DF','ES' => 'ES','GO' => 'GO','MA' => 'MA','MG' => 'MG','MS' => 'MS','MT' => 'MT','PA' => 'PA','PB' => 'PB','PE' => 'PE','PI' => 'PI','PR' => 'PR','RJ' => 'RJ','RN' => 'RN','RO' => 'RO','RR' => 'RR','RS' => 'RS','SC' => 'SC','SE' => 'SE','SP' => 'SP','TO' => 'TO',], isset($aluno) ? $aluno->endereco->uf : (Input::old('uf') ? null : 'SP'),array('class'=>'form-control required uf','id'=>'uf','aria-required'=>"true"))?>
                    </div>
                    <?= $errors->first('uf'); ?>
                </div>

            </div>

            <?= Form::submit(isset($aluno)?'Atualizar':'Cadastrar', array('class' => 'btn btn-success btn-block send-form'));?>
            <?= Form::close() ?>
        </div>

    </div>
</div>

@stop

@section('js')
    <script type="text/javascript" src="{{asset('assets/js/views/aluno.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/validacao/alunoValidator.js')}}"></script>
@stop