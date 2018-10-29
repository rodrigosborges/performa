@extends('template.layout')
@section('title','Formulário')

@section('content')

<div class="card">
    <div class="card-header"><h4>Início</h4></div>
    <div class="card-body">
        <div class="col-md-12 text-center">
                <img src="{{asset('assets/img/logo.png')}}" width="50%" height=150px/>
                <div style="height: 50px"></div>
        </div>		
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">Total de alunos</div>
                    <div class="card-body text-center">{{Aluno::count()}}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">Alunos em débito</div>
                    <div class="card-body text-center">{{Aluno::count()}}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">Alunos bloqueados</div>
                    <div class="card-body text-center">{{Aluno::count()}}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop