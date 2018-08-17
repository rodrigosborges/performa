<?php

class ViagemController extends \BaseController {

	public function index(){
		$data = [
			'estados'			=> MainHelper::fixArray(Estado::orderBy('nome')->get(), 'id','nome'),
			'cidades'			=> MainHelper::fixArray(Cidade::where('estado_id','35')->orderBy('nome')->get(),'id','nome'),
			'tiposvisitantes'	=> MainHelper::fixArray(TipoVisitante::all(),'id','nome',1),
			'tiposdestinos'		=> MainHelper::fixArray(TipoDestino::all(),'id','nome',1),
			'tiposrefeicoes'	=> MainHelper::fixArray(TipoRefeicao::all(),'id','nome',1),
			'tiposmotivos'		=> MainHelper::fixArray(TipoMotivo::all(),'id','nome',1),
			'tiposatrativos'	=> MainHelper::fixArray(TipoAtrativo::all(),'id','nome',1),
			'tiposveiculos'		=> MainHelper::fixArray(TipoVeiculo::all(),'id','nome'),
			'quantidadesvezes'	=> MainHelper::fixArray(QuantidadeVez::all(),'id','nome'),
			'bairros'			=> MainHelper::fixArray(Bairro::all(),'id','nome'),
			'organizacoes'		=> Organizacao::all(),
			'url'				=> url("viagem"),
			'method'			=> 'POST',
			'id'				=>	null
		];
		return View::make('viagem.form',compact('data'));
	}


	public function create(){
	}

	public function store(){
		$dados = Input::all();

		// try{
			$pessoa = Pessoa::where('cpf',FormatterHelper::somenteNumeros($dados['pessoa']['cpf']));
			if(!$pessoa){
				$contato_pessoa = Contato::create($dados['pessoa']['contato']);
				$pessoa = new Pessoa($dados['pessoa']);
				$pessoa->contato()->associate($contato_pessoa)->save();
			}else{
				$pessoa->update($dados['pessoa']);
				$pessoa->contato()->update($dados['pessoa']['contato']);
			}
			
			if($dados['organizacao_id'] == 1){
				$contato_empresa = Contato::create($dados['empresa']['contato']);
				$empresa = new Empresa($dados['empresa']);
				$empresa->contato()->associate($contato_empresa)->save();
			}
			
			$viagem = new Viagem($dados);
			$viagem->empresa()->associate($empresa)->pessoa()->associate($pessoa)->save();
			$viagem->tiposAtrativos()->sync($dados['tipoatrativo']);
			$viagem->tiposMotivos()->sync($dados['tipomotivo']);
			$viagem->tiposRefeicoes()->sync($dados['tiporefeicao']);
			$viagem->tiposVisitantes()->sync($dados['tipovisitante']);
			$viagem->tiposDestinos()->sync($dados['tipodestino']);

			foreach($dados['tipo_veiculo_id'] as $key=>$veiculo){
				$veiculo = new Veiculo;
				$veiculo->placa = $dados['placa'][$key];
				$veiculo->registro = $dados['registro'][$key];
				$veiculo->tipo_veiculo_id = $dados['tipo_veiculo_id'][$key];
				$viagem->veiculos()->save($veiculo);
			}
		// }catch(Exception $e){
		// 	return $e->getMessage();
		// }


		return $dados;
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
