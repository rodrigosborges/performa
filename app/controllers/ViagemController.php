<?php

class ViagemController extends \BaseController {

	public function index(){
		$data = [
			'estados'			=> MainHelper::fixArray(Estado::all(), 'id','nome'),
			'cidades'			=> MainHelper::fixArray(Cidade::where('estado_id','1')->get(),'id','nome'),
			'tiposvisitantes'	=> MainHelper::fixArray(TipoVisitante::all(),'id','nome',1),
			'tiposdestinos'		=> MainHelper::fixArray(TipoDestino::all(),'id','nome',1),
			'tiposrefeicoes'	=> MainHelper::fixArray(TipoRefeicao::all(),'id','nome',1),
			'tiposmotivos'		=> MainHelper::fixArray(TipoMotivo::all(),'id','nome',1),
			'tiposatrativos'	=> MainHelper::fixArray(TipoAtrativo::all(),'id','nome',1),
			'tiposveiculos'		=> MainHelper::fixArray(TipoVeiculo::all(),'id','nome'),
			'organizacoes'		=> Organizacao::all(),
			'url'				=> url("viagem/store"),
			'method'			=> 'POST',
			'id'				=>	null
		];
		return View::make('viagem.form',compact('data'));
	}


	public function create(){
	}

	public function store(){
	}

	public function show($id){
	}

	public function edit($id){
	}

	public function update($id){
	}

	public function destroy($id){
	}


}
