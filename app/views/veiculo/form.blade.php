@extends('template.layout')
@section('title','Formulário')

@section('content')

<div class="card">
    <div class="card-header"><h4>Formulário para solicitar autorização de veículos</h4></div>

    <div class="card-body">
        <h5>ATENÇÃO! O PREENCHIMENTO DESSA ETAPA DO CADASTRO É ESSENCIAL PARA A VALIDAÇÃO DA AUTORIZAÇÃO DE VEÍCULOS.</h5>
        <?= Form::open(array('url' => $data['url'], 'method' => $data['method'],'data-viagem_hash'=> $data['hash'],'data-veiculo_id' => $data['id'] , 'id' => 'form', 'files' => true));?>
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
                    <?= Form::text('empresa_veiculo', isset($viagem) ? $viagem->empresa_veiculo : null, array('class' => 'form-control required', 'placeholder' => 'Nome da empresa do veículo'))?>
                </div>
                <?= $errors->first('empresa_veiculo') ?>
            </div> 
        </div>
        <hr>
        <h5>OS VEÍCULOS NÃO ARMAZENADOS NA TABELA SERÃO DESCONSIDERADOS.</h5>
        <div class="table-bordered table-responsive">
            <table class="table" id="veiculotable">
                <thead>
                    <th>Tipo do veículo</th>
                    <th>Placa</th>
                    <th>Registro EMBRATUR</th>
                    @if(isset($viagem))
                        <th style="min-width: 215px !important">Arquivos</th>
                    @endif
                    <th>Excluir</th>
                </thead>
                <tbody>
                @if(isset($viagem))
                    @foreach($viagem->veiculos as $veiculo)
                    <tr class="excluirVeiculo{{$veiculo->id}}">
                        <td>{{$veiculo->tipo->nome}}</td>
                        <td class="placaveiculo">{{$veiculo->placa}}</td>
                        <td>{{$veiculo->registro}}</td>
                        <td style="min-width 215px !important">                    
                            <div class="input-group">
                                <span class="form-control">{{$veiculo->anexo}}</span>
                                <div class="input-group-append">
                                    <a class="input-group-text" href='{{ url ("download/veiculos/".$veiculo->anexo)}}' title="Download do arquivo">
                                        <span class="fa fa-download"></span>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td><button type='button' class='btn btn-outline-danger btn-block' onclick='excluirVeiculoExistente({{$veiculo->id}})'>Excluir</button></td>
                    </tr>
                    @endforeach    
                @endif
                </tbody>
            </table>
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
                            <?= Form::select('tipo_veiculo_id[]', $data['tiposveiculos'], null,array('class'=>'form-control has_added','aria-required'=>"true" ))?>
                        </div>
                    <?= $errors->first('tipo_veiculo_id.*'); ?>
                    </div>  
                    <div class="form-group col-md-4">
                        <label>Placa do veículo <span>*</span></label>
                        <div class="input-group recontar">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-car"></span>
                            </span>
                            </div>
                            <?= Form::text('placa[]', null,array('class'=>'form-control placa has_added', 'id' => "placa"))?>
                        </div>
                    <?= $errors->first('placa.*'); ?>
                    </div>   
                    <div class="form-group col-md-4">
                        <label>Registro EMBRATUR <span>*</span></label>
                        <div class="input-group recontar">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="fas fa-id-card"></span>
                            </span>
                            </div>
                            <?= Form::text('registro[]', null,array('class'=>'form-control has_added','aria-required'=>"true" ))?>
                        </div>
                    <?= $errors->first('registro.*'); ?>
                    </div> 
                    <div class="form-group col-md-6">
                        <label>Documento do veículo <span>*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-folder-open" aria-hidden="true"></span>
                                </span>
                            </div>
                            <?= Form::file('documentos[veiculo][]', array('style' => 'opacity: 1;','class' => 'form-control has_added', 'id' => 'veiculo')) ?>
                        </div>
                        <?= $errors->first('documentos.veiculo.*') ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Comprovação de regularidade(EMTU, ARTESP e ANTT)<span>{{Auth::check() ? '' : '*'}}</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-folder-open" aria-hidden="true"></span>
                                </span>
                            </div>
                            <?= Form::file('documentos[regularidade][]', array('style' => 'opacity: 1;','class' => 'form-control has_added', 'id' => 'regularidade')) ?>
                        </div>
                        <?= $errors->first('documentos.regularidade.*') ?>
                    </div>      
                </div>
                <hr>
            </div>
        </div>
        <?= Auth::check() ? Form::hidden("logado",1) : "" ?>
        <div class="text-center">
            <button type="button" id="adicionarVeiculo" class="btn btn-success armazenarVeiculo">Armazenar veículo</button>
        </div>
        <br>

        <div class="excluirVeiculos"></div>
        
        <?= Form::hidden('hash', Input::get('hash'),array('class'=>'form-control'))?>

        <?= Form::submit(isset($viagem)?'Atualizar':'Cadastrar', array('class' => 'btn btn-success btn-block send-form'));?>
        <?= Form::close() ?>
    </div>
</div>
@stop

@section('js')
    <script type="text/javascript" src="{{asset('assets/js/views/veiculo.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/validacao/veiculoValidator.js')}}"></script>
@stop