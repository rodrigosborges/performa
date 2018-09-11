<?php
$totais = array();
?>
@extends('template.print')
@section('css')
<style>
.full-table{
    width: 100% !important;
}
.full-table th, .full-table td{
    padding: 5px 2px;
    font-size: 70% !important;
}
.body{
    margin-top: -30px;
}
</style>
@stop
@section('content')
<div class="text-center bold print-line">
    <div class="print-line">RELATÓRIO ESTATÍSTICO</div>
    <div class="print-line">TIPO DE {{mb_strtoupper(str_replace("Viagem","",$titulo),'UTF-8')}}</div><br>
</div>
<table class="full-table">
    <thead>
        <tr>
            <th class="text-center print-heading">Tipo</th>
            <th class="text-center print-heading">Quantidade</th>
        </tr>
    </thead>
    <tbody>
        @foreach($objects as $key => $object)
        <tr>
            <td class="zero text-center">{{ $object->tipo->nome }}</td>
            <td class="zero text-center">{{ $object->total }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop