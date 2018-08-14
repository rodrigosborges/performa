@extends('template.layout')
@section('title','Formulário')

@section('content')

<div class="card">
    <div class="card-header"><h4>Formulário para solicitar autorização de veículos</h4></div>
    <div class="card-body">
        <h4 class="section-title">Forma de organização da viagem</h4>
        <?= Form::open(array('url' => $data['url'], 'method' => $data['method'],'data-viagem_id'=> $data['id'], 'id' => 'form', 'files' => true));?>
        <div class="form-group text-center">
            @foreach($data['organizacoes'] as $key=>$organizacao)
            <div class="custom-control custom-radio custom-control-inline">
                <?= Form::radio('organizacao_id', $organizacao->id, (isset($viagem) && $viagem->organizacao_id) || (!isset($viagem)&& $key==0) == $organizacao->id ? true : false,array('class' => 'custom-control-input', 'id'=>"tipo_$organizacao->id")) ?>
                <label class="custom-control-label" for="tipo_{{$organizacao->id}}">{{$organizacao->nome}}</label>
            </div>
            @endforeach
        </div>
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
                    <?= Form::text('contato[email]', isset($viagem)? $viagem->pessoa->contato->email : null, array('class' => 'form-control required', 'placeholder' => 'E-mail'))?>
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

            <div class="form-group col-md-12">
                <label>Documento do solicitante</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-folder-open" aria-hidden="true"></span>
                        </span>
                    </div>
                    <?= Form::file('documentos[solicitante]', array('style' => 'opacity: 1;','class' => 'form-control', 'id' => 'solicitante')) ?>
                </div>
                <?= $errors->first('documentos.solicitante') ?>
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
                    <?= Form::text('empresa[nome]', isset($viagem)? $viagem->empresa->nome : null, array('class' => 'form-control required', 'placeholder' => 'Nome da empresa'))?>
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
                <label>Fax <span></span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-fax"></span>
                        </span>
                    </div>
                    <?= Form::text('empresa[contato][fax]', isset($viagem)? $viagem->empresa->contato->celular : null, array('class' => 'form-control telefone_numero', 'placeholder' => 'Fax'))?>
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

        <h4 class="section-title">Veículos</h4>
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
        <hr>
        <div id="veiculo">
            <div class="veiculo">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Tipo do veículo <span>*</span></label>
                        <div class="input-group recontar">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-list"></span>
                            </span>
                            </div>
                            <?= Form::select('tipoveiculo[]', $data['tiposveiculos'],isset($viagem) ? $viagem : null,array('class'=>'form-control required','aria-required'=>"true" ))?>
                        </div>
                    <?= $errors->first('tipoveiculo'); ?>
                    </div>  
                    <div class="form-group col-md-4">
                        <label>Placa do veículo <span>*</span></label>
                        <div class="input-group recontar">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-car"></span>
                            </span>
                            </div>
                            <?= Form::text('placa[]', isset($viagem) ? $viagem : null,array('class'=>'form-control required placa','aria-required'=>"true" ))?>
                        </div>
                    <?= $errors->first('placa'); ?>
                    </div>   
                    <div class="form-group col-md-4">
                        <label>Registro EMBRATUR <span>*</span></label>
                        <div class="input-group recontar">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-id-card"></span>
                            </span>
                            </div>
                            <?= Form::text('registro[]', isset($viagem) ? $viagem : null,array('class'=>'form-control required','aria-required'=>"true" ))?>
                        </div>
                    <?= $errors->first('registro'); ?>
                    </div> 
                    <div class="form-group col-md-6">
                        <label>Documento do veículo <span>*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-folder-open" aria-hidden="true"></span>
                                </span>
                            </div>
                            <?= Form::file('documentos[veiculo][]', array('style' => 'opacity: 1;','class' => 'form-control', 'id' => 'veiculo')) ?>
                        </div>
                        <?= $errors->first('documentos.veiculo') ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Comprovação de regularidade(EMTU, ARTESP e ANTT)<span>*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-folder-open" aria-hidden="true"></span>
                                </span>
                            </div>
                            <?= Form::file('documentos[regularidade][]', array('style' => 'opacity: 1;','class' => 'form-control', 'id' => 'regularidade')) ?>
                        </div>
                        <?= $errors->first('documentos.regularidade') ?>
                    </div>      
                </div>
                <hr>
            </div>
        </div>
        <div class="text-center">
            <button type="button" id="adicionarVeiculo" class="btn btn-success">Adicionar veículo</button>
            <button style="display: none" type="button" id="removerVeiculo" class="btn btn-danger">Remover veículo</button>
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
                    <?= Form::select('tipovisitante[]', $data['tiposvisitantes'],isset($viagem) ? $viagem : null,array('class'=>'form-control required selectpicker','aria-required'=>"true", 'multiple', 'onChange' => "especificar('tipovisitante[]', ".array_search('Outros',$data['tiposvisitantes']).", 'especificar_visitante')"))?>
                </div>
            <?= $errors->first('tipovisitante'); ?>
            </div>
            
            <div class="form-group col-md-6" style="display:none" id="especificar_visitante">
                <label>Especificar perfil do visitante <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-info"></span>
                        </span>
                    </div>
                    <?= Form::text('especificar_visitante', isset($viagem)? $viagem : null, array('class' => 'form-control required', 'placeholder' => 'Especificar'))?>
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
                    <?= Form::select('tipodestino[]', $data['tiposdestinos'],isset($viagem) ? $viagem : null,array('class'=>'form-control required selectpicker','aria-required'=>"true", 'multiple', 'onChange' => "especificar('tipodestino[]', ".array_search('Outros',$data['tiposdestinos']).", 'especificar_destino')"))?>
                </div>
            <?= $errors->first('tipodestino'); ?>
            </div>

            <div class="form-group col-md-6" style="display:none" id="especificar_destino">
                <label>Especificar destino <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-info"></span>
                        </span>
                    </div>
                    <?= Form::text('especificar_destino', isset($viagem)? $viagem : null, array('class' => 'form-control required', 'placeholder' => 'Especificar'))?>
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
                    <?= Form::text('local_destino', isset($viagem)? $viagem : null, array('class' => 'form-control required', 'placeholder' => 'Nome do local / Endereço'))?>
                </div>
                <?= $errors->first('local_destino') ?>
            </div> 
            
            <div class="form-group col-md-6">
                <label>Local para refeições <span>*</span></label>
                <div class="input-group recontar">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <span class="fas fa-list"></span>
                    </span>
                    </div>
                    <?= Form::select('tiporefeicao[]', $data['tiposrefeicoes'],isset($viagem) ? $viagem : null,array('class'=>'form-control required selectpicker','aria-required'=>"true", 'multiple', 'onChange' => "especificar('tiporefeicao[]', ".array_search('Outros',$data['tiposrefeicoes']).", 'especificar_refeicao')"))?>
                </div>
            <?= $errors->first('tiporefeicao'); ?>
            </div>


            <div class="form-group col-md-6" style="display:none" id="especificar_refeicao">
                <label>Especificar local para refeições <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-info"></span>
                        </span>
                    </div>
                    <?= Form::text('especificar_refeicao', isset($viagem)? $viagem : null, array('class' => 'form-control required', 'placeholder' => 'Especificar'))?>
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
                    <?= Form::select('tipomotivo[]', $data['tiposmotivos'],isset($viagem) ? $viagem : null,array('class'=>'form-control required selectpicker','aria-required'=>"true", 'multiple', 'onChange' => "especificar('tipomotivo[]', ".array_search('Outros',$data['tiposmotivos']).", 'especificar_motivo')"))?>
                </div>
            <?= $errors->first('tipomotivo'); ?>
            </div>

            <div class="form-group col-md-6" style="display:none" id="especificar_motivo">
                <label>Especificar motivo da viagem <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-info"></span>
                        </span>
                    </div>
                    <?= Form::text('especificar_motivo', isset($viagem)? $viagem : null, array('class' => 'form-control required', 'placeholder' => 'Especificar'))?>
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
                    <?= Form::select('tipoatrativo[]', $data['tiposatrativos'],isset($viagem) ? $viagem : null,array('class'=>'form-control required selectpicker','aria-required'=>"true", 'multiple', 'onChange' => "especificar('tipoatrativo[]', ".array_search('Outros',$data['tiposatrativos']).", 'especificar_atrativo')"))?>
                </div>
            <?= $errors->first('tipoatrativo'); ?>
            </div>

            <div class="form-group col-md-6" style="display:none" id="especificar_atrativo">
                <label>Especificar atrativo principal <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-info"></span>
                        </span>
                    </div>
                    <?= Form::text('especificar_atrativo', isset($viagem)? $viagem : null, array('class' => 'form-control required', 'placeholder' => 'Especificar'))?>
                </div>
                <?= $errors->first('especificar_atrativo') ?>
            </div> 

            <div class="form-group col-md-6">
                <label>Tem roteiro pré-definido? <span>*</span></label>
                <div class="input-group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <?= Form::radio('roteiro_predefinido', 1, (isset($viagem) && $viagem->roteiro_predefinido == 1) ? true : false,array('class' => 'custom-control-input', 'id'=>"tipo_roteiro_1")) ?>
                        <label class="custom-control-label" for="tipo_roteiro_1">Sim</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <?= Form::radio('roteiro_predefinido', 0, (!isset($viagem) || (isset($viagem) && $viagem->roteiro_predefinido == 1)) ? true : false,array('class' => 'custom-control-input', 'id'=>"tipo_roteiro_0")) ?>
                        <label class="custom-control-label" for="tipo_roteiro_0">Não</label>
                    </div>
                </div>
            <?= $errors->first('roteiro_predefinido'); ?>
            </div>
            <div class="form-group col-md-6 roteiro" style="display: none">
                <label>Roteiro <span>*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fas fa-clipboard-list"></span>
                        </span>
                    </div>
                    <?= Form::text('roteiro_especificar', isset($viagem)? $viagem : null, array('class' => 'form-control required', 'placeholder' => 'Roteiro'))?>
                </div>
                <?= $errors->first('roteiro_especificar') ?>
            </div> 
        </div>      


        <?= Form::submit(isset($viagem)?'Atualizar':'Cadastrar', array('class' => 'btn btn-success btn-block'));?>
        <?= Form::close() ?>
    </div>
</div>

@stop

@section('js')
    <script type="text/javascript" src="{{asset('assets/js/views/viagem.js')}}"></script>
@stop