@extends('template.autorizacao')

@section('content')
    <div class="container-autorizacao">
        <div>
            <div style="width: 50%; display:inline-block;">
                <span class="subtitles"><b>Nº:</b></span>
            </div>
            <div style="width: 50%; display:inline-block;">
                <span class="subtitles"><b>PLACA:</b></span>
            </div>
        </div>
        <div style="padding-top: -38px !important;">
            <div style="width: 50%; display:inline-block;">
                <span class="values"><b>{{$veiculo->numero}}</b></span>
            </div>
            <div style="width: 50%; display:inline-block;">
                <span class="values"><b>{{$veiculo->placa}}</b></span>
            </div>
        </div>
        <div style="padding-top: -70px !important;">
            <div style="width: 45%; display:inline-block;text-align:justify;">
                <span class="subtitles"><b>EMPRESA: </b>{{mb_strtoupper($viagem->empresa_veiculo, 'UTF-8')}} ({{mb_strtoupper($veiculo->tipo->nome, 'UTF-8')}})</span>
            </div>
            <div style="width: 45%;margin-left: 5%; display:inline-block;text-align:justify;">
                <span class="subtitles"><b>NOME DO RESPONSÁVEL/TEL: </b>{{mb_strtoupper($viagem->pessoa->nome, 'UTF-8')}} / {{$viagem->pessoa->contato->telefone}}</span>
            </div>
        </div>

        <div style="padding-top: 20px !important;">
            <div style="width: 45%; display:inline-block;text-align:justify;">
                <span class="subtitles"><b>DESTINO: </b>{{mb_strtoupper($viagem->local_destino, 'UTF-8')}}</span>
            </div>
            <div style="width: 45%;margin-left: 5%; display:inline-block;text-align:justify;">
                <span class="subtitles"><b>PERÍODO: </b>{{$viagem->chegada}} À {{$viagem->saida}}</span>
            </div>
        </div>
    </div>
@stop