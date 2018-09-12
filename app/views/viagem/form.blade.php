@extends('template.layout')
@section('title','Formulário')

@section('content')

<div class="card">
    <div class="card-header"><h4>Formulário para solicitar autorização de veículos</h4>
        <ul class="nav nav-tabs nav-justified card-header-tabs">
			<li class="nav-item">
				<a data-toggle="tab" id="informacoes-tab" href="#informacoes" role="tab" aria-controls="informacoes" aria-selected="true" class="nav-link active">Informações</a>
            </li>
            @if(isset($viagem) && $viagem->respostas()->count() > 0)
                <li class="nav-item">
                    <a data-toggle="tab" id="respostas-tab" role="tab" aria-controls="respostas" aria-selected="false" class="nav-link" href="#respostas">Respostas</a>
                </li>
            @endif
		</ul>
    </div>
    <div class="card-body tab-content">
        <div id="informacoes" role="tabpanel" aria-labelledby="informacoes-tab" class="tab-pane fade active show">
            <h5>ATENÇÃO! A SOLICITAÇÃO DEVE SER APRESENTADA COM, NO MÍNIMO, 10 DIAS ÚTEIS DE ANTECEDÊNCIA, A CONTAR DA DATA DA VIAGEM, SOB PENA DE INDEFERIMENTO.</h5>
            <?= Form::open(array('url' => $data['url'], 'method' => $data['method'],'data-viagem_id'=> $data['id'], 'files' => true,'id' => "form"));?>
            <h4 class="section-title">Responsável pela organização da viagem</h4>
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
                        <?= Form::text('pessoa[cpf]', isset($viagem)? $viagem->pessoa->cpf : null, array('class' => 'form-control required cpf', 'placeholder' => 'CPF', isset($viagem) ? 'disabled' : ''))?>
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
                        <?= Form::text('pessoa[contato][email]', isset($viagem)? $viagem->pessoa->contato->email : null, array('class' => 'form-control required', 'placeholder' => 'E-mail'))?>
                    </div>
                    <?= $errors->first('pessoa.contato.email') ?>
                </div>

                <div class="form-group col-md-6">
                    <label>Telefone <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </span>
                        </div>
                        <?= Form::text('pessoa[contato][telefone]', isset($viagem)? $viagem->pessoa->contato->telefone : null, array('class' => 'form-control required telefone_numero', 'placeholder' => 'Telefone'))?>
                    </div>
                    <?= $errors->first('pessoa.contato.telefone') ?>
                </div>

                <div class="form-group col-md-6">
                    <label>Celular <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-mobile-alt"></span>
                            </span>
                        </div>
                        <?= Form::text('pessoa[contato][celular]', isset($viagem)? $viagem->pessoa->contato->celular : null, array('class' => 'form-control required telefone_numero', 'placeholder' => 'Celular'))?>
                    </div>
                    <?= $errors->first('pessoa.contato.celular') ?>
                </div>

                <div class="form-group col-md-12">
                    <label>Documento do solicitante <span>*</span> {{isset($viagem)?"(Inserir somente em caso de alteração do arquivo)":""}}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-folder-open" aria-hidden="true"></span>
                            </span>
                        </div>
                        <?= Form::file('documentos[solicitante]', array('style' => 'opacity: 1;','class' => 'form-control '.(isset($viagem) ? "" : "required"), 'id' => 'solicitante')) ?>
                    </div>
                    <?= $errors->first('documentos.solicitante') ?>
                </div>
                @if(isset($viagem))
                <div class="form-group col-sm-12">
                    <label>Arquivo armazenado</label>
                    <div class="input-group">
                        <span class="form-control">{{$viagem->pessoa->anexo}}</span>
                        <div class="input-group-append">
                            <a class="input-group-text" href='{{ url ("download/pessoas/".$viagem->pessoa->anexo)}}' title="Download do arquivo">
                                <span class="fa fa-download"> Download</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

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
                        <?= Form::select('estado', $data['estados'], isset($viagem) ? $viagem->cidade->estado_id : null,array('class'=>'form-control required estado','id'=>'estado','aria-required'=>"true"))?>
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
                        <?= Form::select('cidade_origem', isset($viagem) ? $data['cidades_visitante'] : [],isset($viagem)?$viagem->cidade_origem :null,array('class'=>'form-control required cidade_id','id'=>'cidade_id','aria-required'=>"true"))?>
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
                        <?= Form::text('numeroPessoas', isset($viagem)? $viagem->numeroPessoas : null, array('class' => 'form-control required numero', 'placeholder' => 'Número de pessoas'))?>
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

            <h4 class="section-title">Organização da viagem</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        @foreach($data['organizacoes'] as $key=>$organizacao)
                        <div class="custom-control custom-radio custom-control-inline">
                            <?= Form::radio('organizacao_id', $organizacao->id, (isset($viagem) && $viagem->organizacao_id == $organizacao->id) || (!isset($viagem)&& $key==0) ? true : false,array('class' => 'custom-control-input required', 'id'=>"tipo_$organizacao->id")) ?>
                            <label class="custom-control-label" for="tipo_{{$organizacao->id}}">{{$organizacao->nome}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row empresa" style="{{Input::old('organizacao_id')==2 || @$viagem->organizacao_id == 2 ?'display:none':''}}">
                <div class="form-group col-md-12">
                    <label>Nome da empresa <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-building"></span>
                            </span>
                        </div>
                        <?= Form::text('empresa[nome]', !empty($viagem->empresa) ? $viagem->empresa->nome : null, array('class' => 'form-control required', 'placeholder' => 'Nome da empresa'))?>
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
                        <?= Form::text('empresa[contato][email]', !empty($viagem->empresa) ? $viagem->empresa->contato->email : null, array('class' => 'form-control required', 'placeholder' => 'E-mail'))?>
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
                        <?= Form::text('empresa[contato][telefone]', !empty($viagem->empresa) ? $viagem->empresa->contato->telefone : null, array('class' => 'form-control required telefone_numero', 'placeholder' => 'Telefone'))?>
                    </div>
                    <?= $errors->first('empresa.contato.telefone') ?>
                </div>

                <div class="form-group col-md-12">
                    <label>Site</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-desktop"></span>
                            </span>
                        </div>
                        <?= Form::text('empresa[site]', !empty($viagem->empresa) ? $viagem->empresa->site : null, array('class' => 'form-control', 'placeholder' => 'Site'))?>
                    </div>
                    <?= $errors->first('empresa.site') ?>
                </div>

                
                <div class="form-group col-md-5">
                    <label>Estado <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-map"></span>
                            </span>
                        </div>
                        <?= Form::select('empresa[estado]', $data['estados'],!empty($viagem->empresa) ? $viagem->empresa->cidade->estado_id :null,array('class'=>'form-control required estado','id'=>'estado','aria-required'=>"true"))?>
                    </div>
                    <?= $errors->first('empresa.estado'); ?>
                </div>

                <div class="form-group col-md-7">
                    <label>Cidade <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-map-marker-alt"></span>
                            </span>
                        </div>
                        <?= Form::select('empresa[cidade_id]', !empty($viagem->empresa) ? $data['cidades_empresa'] : [],isset($viagem->empresa)? $viagem->empresa->cidade_id :null,array('class'=>'form-control required cidade_id','id'=>'cidade_id','aria-required'=>"true"))?>                </div>
                    <?= $errors->first('empresa.cidade_id'); ?>
                </div>
            </div>

            <h4 class="section-title">Dados gerais</h4>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Primeira vez no município? <span>*</span></label>
                    <div class="input-group">
                        <div class="custom-control custom-radio custom-control-inline">
                            <?= Form::radio('primeira_vez', 1, (!isset($viagem) || (isset($viagem) && $viagem->primeira_vez == 1)) ? true : false,array('class' => 'custom-control-input required', 'id'=>"tipo_primeiravez_1")) ?>
                            <label class="custom-control-label" for="tipo_primeiravez_1">Sim</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <?= Form::radio('primeira_vez', 0, (isset($viagem) && $viagem->primeira_vez == 0) ? true : false,array('class' => 'custom-control-input required', 'id'=>"tipo_primeiravez_0")) ?>
                            <label class="custom-control-label" for="tipo_primeiravez_0">Não</label>
                        </div>
                    </div>
                <?= $errors->first('primeira_vez'); ?>
                </div>
                <div class="form-group col-md-6 primeira_vez" style="{{Input::old('quantidade_vez_id') || isset($viagem->quantidade_vez_id) ?'':'display:none'}}">
                    <label>Quantas vezes já esteve no município <span>*</span></label>
                    <div class="input-group recontar">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-list"></span>
                        </span>
                        </div>
                        <?= Form::select('quantidade_vez_id', $data['quantidadesvezes'],isset($viagem) ? $viagem->quantidade_vez_id : null,array('class'=>'form-control','aria-required'=>"true", Input::old('quantidade_vez_id') || isset($viagem->quantidade_vez_id) ?'':'disabled'))?>
                    </div>
                <?= $errors->first('quantidade_vez_id'); ?>
                </div>
                <div class="form-group col-md-6">
                    <label>Perfil do visitante <span>*</span></label>
                    <div class="input-group recontar">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-list"></span>
                        </span>
                        </div>
                        <?= Form::select('tipovisitante[]', $data['tiposvisitantes'],isset($viagem) ? FormatterHelper::multiSelectValues($viagem->tiposVisitantes) : null,array('class'=>'form-control required selectpicker','aria-required'=>"true",'multiple', 'data-selected-text-format' =>"count", 'onChange' => "especificar('tipovisitante[]', ".array_search('Outros',$data['tiposvisitantes']).", 'especificar_visitante')"))?>
                    </div>
                <?= $errors->first('tipovisitante'); ?>
                </div>
                <div class="form-group col-md-6" id="especificar_visitante" style="{{Input::old('especificar_visitante') || (isset($viagem) && $viagem->tiposVisitantes()->first()->pivot->especificar) ?'':'display:none'}}">
                    <label>Especificar perfil do visitante <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-info"></span>
                            </span>
                        </div>
                        <?= Form::text('especificar_visitante', isset($viagem)? $viagem->tiposVisitantes()->first()->pivot->especificar : null, array('class' => 'form-control required', 'placeholder' => 'Especificar', Input::old('especificar_visitante') || (isset($viagem) && $viagem->tiposVisitantes()->first()->pivot->especificar)?'':'disabled'))?>
                    </div>
                    <?= $errors->first('especificar_visitante') ?>
                </div> 

                <div class="form-group col-md-6">
                    <label>Destino <span>*</span></label>
                    <div class="input-group recontar">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-list"></span>
                        </span>
                        </div>
                        <?= Form::select('tipodestino[]', $data['tiposdestinos'],isset($viagem) ? FormatterHelper::multiSelectValues($viagem->tiposDestinos) : null,array('class'=>'form-control required selectpicker','aria-required'=>"true", 'multiple', 'data-selected-text-format' =>"count", 'onChange' => "especificar('tipodestino[]', ".array_search('Outros',$data['tiposdestinos']).", 'especificar_destino')"))?>
                    </div>
                <?= $errors->first('tipodestino'); ?>
                </div>

                <div class="form-group col-md-6" style="{{Input::old('especificar_destino') || (isset($viagem) && $viagem->tiposDestinos()->first()->pivot->especificar) ?'':'display:none'}}" id="especificar_destino" >
                    <label>Especificar destino <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-info"></span>
                            </span>
                        </div>
                        <?= Form::text('especificar_destino', isset($viagem)? $viagem->tiposDestinos()->first()->pivot->especificar : null, array('class' => 'form-control required', 'placeholder' => 'Especificar',Input::old('especificar_destino') || (isset($viagem) && $viagem->tiposDestinos()->first()->pivot->especificar)?'':'disabled'))?>
                    </div>
                    <?= $errors->first('especificar_destino') ?>
                </div> 

                <div class="form-group col-md-6">
                    <label>Nome do local / Endereço <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-map"></span>
                            </span>
                        </div>
                        <?= Form::text('local_destino', isset($viagem)? $viagem->local_destino : null, array('class' => 'form-control required', 'placeholder' => 'Nome do local / Endereço'))?>
                    </div>
                    <?= $errors->first('local_destino') ?>
                </div> 

                <div class="form-group col-md-6">
                    <label>Bairro <span>*</span></label>
                    <div class="input-group recontar">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-list"></span>
                        </span>
                        </div>
                        <?= Form::select('bairro_id', $data['bairros'],isset($viagem) ? $viagem->bairro_id : null,array('class'=>'form-control required','aria-required'=>"true" ))?>
                    </div>
                <?= $errors->first('bairro_id'); ?>
                </div>  
                
                <div class="form-group col-md-6">
                    <label>Local para refeições <span>*</span></label>
                    <div class="input-group recontar">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-list"></span>
                        </span>
                        </div>
                        <?= Form::select('tiporefeicao[]', $data['tiposrefeicoes'],isset($viagem) ? FormatterHelper::multiSelectValues($viagem->tiposRefeicoes) : null,array('class'=>'form-control required selectpicker','aria-required'=>"true", 'multiple', 'data-selected-text-format' =>"count", 'onChange' => "especificar('tiporefeicao[]', ".array_search('Outros',$data['tiposrefeicoes']).", 'especificar_refeicao')"))?>
                    </div>
                <?= $errors->first('tiporefeicao'); ?>
                </div>


                <div class="form-group col-md-6" style="{{Input::old('especificar_refeicao') || (isset($viagem) && $viagem->tiposRefeicoes()->first()->pivot->especificar)?'':'display:none'}}" id="especificar_refeicao">
                    <label>Especificar local para refeições <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-info"></span>
                            </span>
                        </div>
                        <?= Form::text('especificar_refeicao', isset($viagem)? $viagem->tiposRefeicoes()->first()->pivot->especificar : null, array('class' => 'form-control required', 'placeholder' => 'Especificar',Input::old('especificar_refeicao') || (isset($viagem) && $viagem->tiposRefeicoes()->first()->pivot->especificar)?'':'disabled'))?>
                    </div>
                    <?= $errors->first('especificar_refeicao') ?>
                </div> 

                <div class="form-group col-md-6">
                    <label>Motivo da viagem <span>*</span></label>
                    <div class="input-group recontar">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-list"></span>
                        </span>
                        </div>
                        <?= Form::select('tipomotivo[]', $data['tiposmotivos'],isset($viagem) ? FormatterHelper::multiSelectValues($viagem->tiposMotivos) : null,array('class'=>'form-control required selectpicker','aria-required'=>"true", 'multiple', 'data-selected-text-format' =>"count", 'onChange' => "especificar('tipomotivo[]', ".array_search('Outros',$data['tiposmotivos']).", 'especificar_motivo')"))?>
                    </div>
                <?= $errors->first('tipomotivo'); ?>
                </div>

                <div class="form-group col-md-6" style="{{Input::old('especificar_motivo') || (isset($viagem) && $viagem->tiposMotivos()->first()->pivot->especificar)?'':'display:none'}}" id="especificar_motivo">
                    <label>Especificar motivo da viagem <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-info"></span>
                            </span>
                        </div>
                        <?= Form::text('especificar_motivo', isset($viagem)? $viagem->tiposMotivos()->first()->pivot->especificar : null, array('class' => 'form-control required', 'placeholder' => 'Especificar',Input::old('especificar_motivo') || (isset($viagem) && $viagem->tiposMotivos()->first()->pivot->especificar)?'':'disabled'))?>
                    </div>
                    <?= $errors->first('especificar_motivo') ?>
                </div> 
                
                <div class="form-group col-md-6">
                    <label>Atrativo principal <span>*</span></label>
                    <div class="input-group recontar">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-list"></span>
                        </span>
                        </div>
                        <?= Form::select('tipoatrativo[]', $data['tiposatrativos'],isset($viagem) ? FormatterHelper::multiSelectValues($viagem->tiposAtrativos) : null,array('class'=>'form-control required selectpicker','aria-required'=>"true", 'multiple', 'data-selected-text-format' =>"count", 'onChange' => "especificar('tipoatrativo[]', ".array_search('Outros',$data['tiposatrativos']).", 'especificar_atrativo')"))?>
                    </div>
                <?= $errors->first('tipoatrativo'); ?>
                </div>

                <div class="form-group col-md-6" style="{{Input::old('especificar_atrativo') || (isset($viagem) && $viagem->tiposAtrativos()->first()->pivot->especificar)?'':'display:none'}}" id="especificar_atrativo">
                    <label>Especificar atrativo principal <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-info"></span>
                            </span>
                        </div>
                        <?= Form::text('especificar_atrativo', isset($viagem)? $viagem->tiposAtrativos()->first()->pivot->especificar : null, array('class' => 'form-control required', 'placeholder' => 'Especificar',Input::old('especificar_atrativo') || (isset($viagem) && $viagem->tiposAtrativos()->first()->pivot->especificar) ?'':'disabled'))?>
                    </div>
                    <?= $errors->first('especificar_atrativo') ?>
                </div> 

                <div class="form-group col-md-6">
                    <label>Tem roteiro pré-definido? <span>*</span></label>
                    <div class="input-group">
                        <div class="custom-control custom-radio custom-control-inline">
                            <?= Form::radio('roteiro_predefinido', 1, (isset($viagem) && $viagem->roteiro_predefinido == 1) ? true : false,array('class' => 'custom-control-input required', 'id'=>"tipo_roteiro_1")) ?>
                            <label class="custom-control-label" for="tipo_roteiro_1">Sim</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <?= Form::radio('roteiro_predefinido', 0, (!isset($viagem) || (isset($viagem) && $viagem->roteiro_predefinido == 0)) ? true : false,array('class' => 'custom-control-input required', 'id'=>"tipo_roteiro_0")) ?>
                            <label class="custom-control-label" for="tipo_roteiro_0">Não</label>
                        </div>
                    </div>
                <?= $errors->first('roteiro_predefinido'); ?>
                </div>
                <div class="form-group col-md-6 roteiro" style="{{Input::old('roteiro_especificar') || isset($viagem->roteiro_especificar)?'':'display:none'}}">
                    <label>Roteiro <span>*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-clipboard-list"></span>
                            </span>
                        </div>
                        <?= Form::text('roteiro_especificar', isset($viagem)? $viagem->roteiro_especificar : null, array('class' => 'form-control', 'placeholder' => 'Roteiro', Input::old('roteiro_especificar') || isset($viagem->roteiro_especificar) ?'':'required'))?>
                    </div>
                    <?= $errors->first('roteiro_especificar') ?>
                </div> 
            </div>     
            <h4 class="section-title">Sugestões e reclamações</h4>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-align-justify"></span>
                            </span>
                        </div>
                        <?= Form::textarea('sugestao', isset($viagem)? $viagem->sugestao : null, array('class' => 'form-control', 'placeholder' => 'Digite aqui suas reclamações e sugestões', 'rows' => 5))?>
                    </div>
                    <?= $errors->first('sugestao') ?>
                </div>
            </div>
            
            @if(isset($viagem))
            <h4 class="section-title">Enviar arquivos</h4>
            <div class="form-group">
                <label>Envie arquivos aqui caso necessário</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-folder-open" aria-hidden="true"></span>
                        </span>
                    </div>
                    <?= Form::file('anexo[]', array('style' => 'opacity: 1;','class' => 'form-control', 'id' => 'anexo', 'multiple')) ?>
                </div>
                <?= $errors->first('anexo') ?>
            </div>
            @endif


            <?= Form::submit(isset($viagem)?'Atualizar':'Cadastrar', array('class' => 'btn btn-success btn-block send-form'));?>
            <?= Form::close() ?>
        </div>
        @if(isset($viagem) && $viagem->respostas()->count() > 0)
            <div id="respostas" role="tabpanel" aria-labelledby="respostas-tab" class="tab-pane fade">
                @foreach($viagem->respostas as $resposta)
                <h4 class="section-title">{{FormatterHelper::setFullDate($resposta->created_at)}}</h4>
                <div class="row col-md-12">
                    <div class="form-group col-sm-6">
                        <label ><strong>Tipo</strong></label>
                        <p class="card-text">{{$resposta->tipo_resposta()->first()->nome}}</p>
                    </div>
                    @if($resposta->anexo)
                        <div class="form-group col-sm-6">
                            <label ><strong>Arquivos</strong></label>
                            <div class="input-group">
                                <span class="form-control">{{$resposta->anexo}}</span>
                                <div class="input-group-append">
                                    <a class="input-group-text" href='{{ url ("download/respostas/".$resposta->anexo)}}' title="Download do arquivo">
                                        <span class="fa fa-download"> Download</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group col-sm-12">
                        <label ><strong>Texto</strong></label>
                        <p class="card-text">{{$resposta->texto}}</p>
                    </div>

                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

@stop

@section('js')
    <script type="text/javascript" src="{{asset('assets/js/views/viagem.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/validacao/viagemValidator.js')}}"></script>

    <script>
        @if(!isset($viagem))
            findElements($('select[name="estado"]').val(), $('select[name="cidade_origem"]'), 'Estado', 'cidades', {{Input::old('cidade_origem') ? Input::old('cidade_origem') : null}})
            findElements($('select[name="empresa[estado]"]').val(), $('select[name="empresa[cidade_id]"]'), 'Estado', 'cidades', {{Input::old('empresa.cidade_id') ? Input::old('empresa.cidade_id') : null}})
        @endif
    </script>
@stop