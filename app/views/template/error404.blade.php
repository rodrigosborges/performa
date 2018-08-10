@extends('template.layout')
@section('content')
<div class="card">
    <div class="card-body text-center">
        <h1>404</h1>
        <h2>Ops! Página não encontrada.</h2>
        <p>Parece que esta página já não existe por aqui.</p>
        <p>Voltar para a <a href="{{ url('/')}}">Página inicial</a>?</p>
    </div>
</div>
@stop
