@extends('template.layout')
@section('title','Turismo')

@section('content')

<div class="card">
    <div class="card-header"><h4>Aluno: {{$aluno->nome}} - Matrícula: {{$aluno->matricula}}</h4>
        <ul class="nav nav-tabs nav-justified card-header-tabs">
			<li class="nav-item">
				<a data-toggle="tab" id="informacoes-tab" href="#informacoes" role="tab" aria-controls="informacoes" aria-selected="true" class="nav-link active">Informações</a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" id="pagamentos-tab" role="tab" aria-controls="pagamentos" aria-selected="false" class="nav-link" href="#pagamentos">Pagamentos</a>
            </li>
		</ul>
    </div>
    <div class="card-body tab-content">
        <div id="informacoes" role="tabpanel" aria-labelledby="informacoes-tab" class="tab-pane fade active show">
            <h4 class="section-title">Dados pessoais</h4>
            <div class="row col-md-12">
                <div class="form-group col-sm-6">
                    <label ><strong>Nome</strong></label>
                    <p class="card-text">{{$aluno->nome}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>CPF</strong></label>
                    <p class="card-text">{{$aluno->cpf}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Idade</strong></label>
                    <p class="card-text">{{(new DateTime())->diff(new DateTime(FormatterHelper::brToEnDate($aluno->data_nascimento)))->y}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Data de nascimento</strong></label>
                    <p class="card-text">{{$aluno->data_nascimento}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Sexo</strong></label>
                    <p class="card-text">{{$aluno->sexo == 1 ? "Masculino" : "Feminino"}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Matrícula</strong></label>
                    <p class="card-text">{{$aluno->matricula}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Plano</strong></label>
                    <p class="card-text">{{$aluno->plano->nome." - R$ ".number_format($aluno->plano->valor, 2, ',', ' ')}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Dia de pagamento</strong></label>
                    <p class="card-text">{{$aluno->dia_pagamento}}</p>
                </div>
            </div>
            <h4 class="section-title">Contato</h4>
            <div class="row col-md-12">
                <div class="form-group col-sm-6">
                    <label ><strong>E-mail</strong></label>
                    <p class="card-text">{{$aluno->contato->email}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Telefone</strong></label>
                    <p class="card-text">{{$aluno->contato->telefone}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Celular</strong></label>
                    <p class="card-text">{{$aluno->contato->celular}}</p>
                </div>
            </div>
            <h4 class="section-title">Endereço</h4>
            <div class="row col-md-12">
                @if($aluno->endereco->cep)
                    <div class="form-group col-sm-6">
                        <label ><strong>CEP</strong></label>
                        <p class="card-text">{{$aluno->endereco->cep}}</p>
                    </div>
                @endif
                <div class="form-group col-sm-6">
                    <label ><strong>Endereço</strong></label>
                    <p class="card-text">{{$aluno->endereco->endereco}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Bairro</strong></label>
                    <p class="card-text">{{$aluno->endereco->bairro}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Cidade</strong></label>
                    <p class="card-text">{{$aluno->endereco->cidade}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>UF</strong></label>
                    <p class="card-text">{{$aluno->endereco->uf}}</p>
                </div>
            </div>
        </div>

        <div id="pagamentos" role="tabpanel" aria-labelledby="pagamentos-tab" class="tab-pane fade">
            <?php 
                setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
                date_default_timezone_set( 'America/Sao_Paulo' ); 
            ?>
            @foreach($aluno->pagamentos as $pagamento)
            <div class="row">
                <div class="col-sm-{{$pagamento->data_pagamento ? '12' : 9}}">
                    <h4 class="section-title" style="{{$pagamento->atrasado() ? 'color: red' : ''}}">Pagamento {{$pagamento->data_pagamento ? "" : "não"}} efetuado</h4>
                </div>
                <div class="col-sm-3">
                    @if(!$pagamento->data_pagamento)
                        <a class="btn btn-success btn-block" href="{{url('efetuarPagamento/'.$pagamento->id)}}">Pagar</a>
                    @endif
                </div>
            </div>
            <div class="row col-md-12">
                <div class="form-group col-sm-6">
                    <label ><strong>Mês de referência</strong></label>
                    <p class="card-text">{{ strftime('%B de %Y', strtotime($pagamento->data)) }}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Valor</strong></label>
                    <p class="card-text">R$ {{number_format($pagamento->valor, 2, ',', ' ')}}</p>
                </div>
                <div class="form-group col-sm-6">
                    <label ><strong>Vencimento</strong></label>
                    <p class="card-text">{{$aluno->pagamentos()->count() == 1 ? strftime('%d/%m/%Y',strtotime($aluno->created_at)) :$aluno->dia_pagamento.strftime('/%m/%Y', strtotime($pagamento->data))}}</p>
                </div>
                @if($pagamento->data_pagamento)
                    <div class="form-group col-sm-6">
                        <label ><strong>Data do pagamento</strong></label>
                        <p class="card-text">{{$pagamento->data_pagamento}}</p>
                    </div>
                @endif
            </div>
            @endforeach
        </div>

    </div>
</div>
@stop

@section('js')
    <script>
        $(document).ready(function(){
            $('#form').validate({
                rules: {
                    "anexo[]": {
                        multiple_extensions: 'jpg|jpeg|png|pdf',
                    }
                },
                messages:{}
            })
            $(".send-form").on('click',function(){
                if($("#form").valid()){
                    $(".send-form").prop("disabled",true)
                    $("#form").submit()
                }
            })
        })
    </script>
@stop