<?php

class AlunoController extends \BaseController {

	public function index(){
		return View::make('aluno.index',compact('data'));
	}


	public function create(){
		$data = [
			'title'				=> "Cadastro de aluno",
			'planos'			=> MainHelper::fixArray(Plano::all(),'id','nome'),
			'url'				=> url("aluno"),
			'method'			=> 'POST',
			'id'				=>	null
		];
		return View::make('aluno.form',compact('data'));
	}

	public function store(){
		$dados = Input::all();
		
		$validator = Validator::make($dados, AlunoValidator::rules(null, $dados));
		if($validator->fails()){
			$validator->getMessageBag()->setFormat('<label class="error">:message</label>');
			return Redirect::back()->withInput()->withErrors($validator)->with('warning','Alguns campos são obrigatórios, favor preenche-los corretamente.');
		}
		DB::beginTransaction();
		try{
			$endereco = Endereco::create($dados);
			$contato = Contato::create($dados);
			$dados['endereco_id'] = $endereco->id;
			$dados['contato_id'] = $contato->id;
			if(!$dados['matricula']){
				$random = rand(1000, 9999);
				while(Aluno::where('matricula',$random)->count() > 0){
					$random = rand(1000, 9999);
				}
				$dados['matricula'] = $random;
			}
			$aluno = Aluno::create($dados);
			$aluno->pagamentos()->save(new Pagamento(['valor' => $aluno->plano->valor, 'data' => date("Y-m-01")]));
		}catch(Exception $e){
			DB::rollback();
			return Redirect::back()->withInput()->with('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.');
		}
		DB::commit();

		return Redirect::back()->with('success', "<a href='".url("aluno/$aluno->id")."'>".($dados['sexo'] == 1 ? "Aluno" : "Aluna")." $aluno->nome (Matrícula $aluno->matricula) ".($dados['sexo'] == 1 ? "cadastrado" : "cadastrada")." com sucesso</a>");
	}

	public function show($id){
		$aluno = Aluno::find($id);
		return View::make('aluno.show',compact('aluno'));
	}

	public function edit($id){
		$aluno = Aluno::find($id);

		if(!$aluno)
			return Redirect::to('/')->with('error','Aluno não encontrado');

		$data = [
			'title'			=> "Edição de aluno",
			'planos'		=> MainHelper::fixArray(Plano::all(),'id','nome'),
			'url'			=> url("aluno/$id"),
			'method'		=> 'PUT',
			'id'			=>	$id
		];
			
		return View::make('aluno.form',compact('data','aluno'));
	}

	public function update($id){
		$dados = Input::all();
		$aluno = Aluno::find($id);
		if(!$aluno)
			return Redirect::to('/')->with('error','Aluno não encontrado');

		$validator = Validator::make($dados, AlunoValidator::rules($id, $dados));
		if($validator->fails()){
			$validator->getMessageBag()->setFormat('<label class="error">:message</label>');
			return Redirect::back()->withInput()->withErrors($validator)->with('warning','Alguns campos são obrigatórios, favor preenche-los corretamente.');
		}
		DB::beginTransaction();
		try{
			$aluno->endereco->update($dados);
			$aluno->contato->update($dados);
			$aluno->update($dados);
		}catch(Exception $e){
			DB::rollback();
			return Redirect::back()->withInput()->with('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.');
		}
		DB::commit();

		return Redirect::back()->with('success', ($aluno->sexo == 1 ? "Aluno" : "Aluna")." $aluno->nome (Matrícula $aluno->matricula) ".($aluno->sexo == 1 ? "editado" : "editada")." com sucesso");	}

	public function destroy($id){
		try {
			$aluno = Aluno::find($id);
			$aluno->delete();
		}catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->with('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.')->withInput();
		}
		DB::commit();
		return Redirect::back()->with('success','Aluno desativado com sucesso.');
	}

	public function listar($tipo){
		$dados = Input::all();
		$aluno = new Aluno;
				
		if($dados['cpf'])
			$aluno = $aluno->where('cpf','LIKE',"%".$dados['cpf']."%");

		if($dados['nome'])
			$aluno = $aluno->where('nome','LIKE',"%".$dados['nome']."%");
	
		if($dados['matricula'])
			$aluno = $aluno->where('matricula','LIKE',"%".$dados['matricula']."%");

		if($tipo == 'inativos')
			$aluno = $aluno->onlyTrashed();

		$elementos = $aluno->paginate(10);

		return View::make('aluno.table', compact('elementos'));
	}

	public function efetuarPagamento($id){
		$pag = Pagamento::find($id);
		$pag->data_pagamento = date('Y-m-d');
		$pag->update();
		return Redirect::back()->with('success','Pagamento efetuado com sucesso');
	}

}
