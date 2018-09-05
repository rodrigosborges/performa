<?php

class ViagemController extends \BaseController {

	public function index(){
		$data = [
			'status'	=> MainHelper::fixArray(Status::all(),'id','nome'),
		];
		return View::make('viagem.index',compact('data'));
	}


	public function create(){
		$data = [
			'estados'			=> MainHelper::fixArray(Estado::orderBy('nome')->get(), 'id','nome'),
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

	public function store(){
		$dados = Input::all();
		$dados['pessoa']['cpf'] = FormatterHelper::somenteNumeros($dados['pessoa']['cpf']);	
		$validator = Validator::make($dados, ViagemValidator::rules(null, $dados));
		if($validator->fails()){
			$validator->getMessageBag()->setFormat('<label class="error">:message</label>');
			return Redirect::back()->withInput()->withErrors($validator)->with('warning','Alguns campos são obrigatórios, favor preenche-los corretamente.');
		}
		
		DB::beginTransaction();
		try{
			#troca os campos com valores "" por null
			$dados = array_map(function($dado){ 
				if($dado == "")
					return null;
				else
					return $dado;
			},$dados);
			
			$viagem = new Viagem($dados);
			$viagem->hash = Hash::make("hash");
			$viagem->status_id = 1;
			
			#cria arquivo do documento do solicitante
			$ext = pathinfo($_FILES['documentos']['name']['solicitante'])['extension'];
			$file = base_path()."/pessoas"."/".$dados['pessoa']['cpf'].".".$ext;
			move_uploaded_file($_FILES['documentos']['tmp_name']['solicitante'],
			 $file);
			$zip = new ZipArchive;
			$zip->open(base_path().'/'.'pessoas/'.$dados['pessoa']['cpf'].'.zip', ZipArchive::CREATE);
			$zip->addFile($file, $dados['pessoa']['cpf'].".".$ext);
			$zip->close();
			unlink($file);

			#create ou update de pessoa conforme o cpf
			$pessoa = Pessoa::where('cpf',$dados['pessoa']['cpf'])->first();
			if(!$pessoa){
				$contato_pessoa = Contato::create($dados['pessoa']['contato']);
				$pessoa = new Pessoa($dados['pessoa']);
				$pessoa->anexo = $dados['pessoa']['cpf'].".zip";
				$pessoa->contato()->associate($contato_pessoa)->save();
			}else{
				$pessoa->update($dados['pessoa']);
				$pessoa->contato()->update($dados['pessoa']['contato']);
			} 
			$viagem->pessoa()->associate($pessoa);


			#cadastra a empresa caso a viagem seja organizada por uma
			if($dados['organizacao_id'] == 1){
				$contato_empresa = Contato::create($dados['empresa']['contato']);
				$empresa = new Empresa($dados['empresa']);
				$empresa->contato()->associate($contato_empresa)->save();
				$viagem->empresa()->associate($empresa);
			}

			$viagem->save();
			
			#salva os relacionamentos many to many da viagem
			MainHelper::manyToMany($viagem->tiposAtrativos(), $dados['tipoatrativo'], @$dados['especificar_atrativo']);
			MainHelper::manyToMany($viagem->tiposMotivos(), $dados['tipomotivo'], @$dados['especificar_motivo']);
			MainHelper::manyToMany($viagem->tiposRefeicoes(), $dados['tiporefeicao'], @$dados['especificar_refeicao']);
			MainHelper::manyToMany($viagem->tiposVisitantes(), $dados['tipovisitante'], @$dados['especificar_visitante']);
			MainHelper::manyToMany($viagem->tiposDestinos(), $dados['tipodestino'], @$dados['especificar_destino']);

			$params = [
				'texto'		=> "O cadastro para autorização de veículos é divido em duas partes. A segunda parte do formulário que é destinada para os veículos estará disponível no link acima, e é necessária para validar seu formulário.",
				'titulo'	=> 'Link para continuar o cadastro <a href="'.url('veiculo?hash='.$viagem->hash).'">aqui</a>',
				'to'		=> $viagem->pessoa->contato->email,
				'assunto'	=> 'Cadastro parcial - Autorização de veículos'
			];

			Mail::send('email.comunicar', ['dados' => $params], function($message) use($params){
				$message->subject($params['assunto']);
				$message->to($params['to']);
			});

		}catch(Exception $e){
			DB::rollback();
			return Redirect::back()->withInput()->with('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.');
		}
		DB::commit();

		return Redirect::to('veiculo?hash='.$viagem->hash)->with('success', "Primeira etapa cadastrada com sucesso.<br>Caso não seja possível efetuar o cadastro de veículos no momento, utilize esse link: <b>".url("veiculo?hash=$viagem->hash")."</b>");
	}

	public function show($id){
		$viagem = Viagem::find($id);
		$data = [
			'tipos_respostas' =>  MainHelper::fixArray(TipoResposta::all(),'id','nome'),
		];
		return View::make('viagem.show',compact('viagem','data'));
	}

	public function edit($id){
		$viagem = Viagem::find($id);

		if($viagem->status_id != 3 || $viagem->hash != Input::get('hash'))
			return Redirect::to('viagem/create')->with('error','Edição de formulário não disponível');

		$data = [
			'estados'			=> MainHelper::fixArray(Estado::orderBy('nome')->get(), 'id','nome'),
			'cidades_visitante'=> MainHelper::fixArray(Cidade::where('estado_id',$viagem->cidade->estado_id)->get(),'id','nome'),
			'tiposvisitantes'	=> MainHelper::fixArray(TipoVisitante::all(),'id','nome',1),
			'tiposdestinos'		=> MainHelper::fixArray(TipoDestino::all(),'id','nome',1),
			'tiposrefeicoes'	=> MainHelper::fixArray(TipoRefeicao::all(),'id','nome',1),
			'tiposmotivos'		=> MainHelper::fixArray(TipoMotivo::all(),'id','nome',1),
			'tiposatrativos'	=> MainHelper::fixArray(TipoAtrativo::all(),'id','nome',1),
			'tiposveiculos'		=> MainHelper::fixArray(TipoVeiculo::all(),'id','nome'),
			'quantidadesvezes'	=> MainHelper::fixArray(QuantidadeVez::all(),'id','nome'),
			'bairros'			=> MainHelper::fixArray(Bairro::all(),'id','nome'),
			'organizacoes'		=> Organizacao::all(),
			'url'				=> url("viagem/$id"),
			'method'			=> 'PUT',
			'id'				=>	$id
		];

		if($viagem->empresa){
			$data+= [
				'cidades_empresa'=> MainHelper::fixArray(Cidade::where('estado_id',$viagem->empresa->cidade->estado_id)->get(),'id','nome')
			];
		}
			
		return View::make('viagem.form',compact('data','viagem'));
	}

	public function update($id){
		$dados = Input::except('pessoa.cpf');
		$validator = Validator::make($dados, ViagemValidator::rules($id, $dados));
		if($validator->fails()){
			$validator->getMessageBag()->setFormat('<label class="error">:message</label>');
			return Redirect::back()->withInput()->withErrors($validator)->with('warning','Alguns campos são obrigatórios, favor preenche-los corretamente.');
		}
		
		DB::beginTransaction();
		try{
			#troca os campos com valores "" por null
			$dados = array_map(function($dado){ 
				if($dado == "")
					return null;
				else
					return $dado;
			},$dados);
			
			$viagem = Viagem::find($id);
			
			#cria arquivo do documento do solicitante
			$cpf = FormatterHelper::somenteNumeros($viagem->pessoa->cpf);
			if($dados['documentos']['solicitante']){
				$ext = pathinfo($_FILES['documentos']['name']['solicitante'])['extension'];
				$file = base_path()."/pessoas"."/".$cpf.".".$ext;
				move_uploaded_file($_FILES['documentos']['tmp_name']['solicitante'],
				$file);
				$zip = new ZipArchive;
				$zip->open(base_path().'/'.'pessoas/'.$cpf.'.zip', ZipArchive::CREATE);
				$zip->addFile($file, $cpf.".".$ext);
				$zip->close();
				unlink($file);
			}

			if(!empty($dados['anexo'])){
				$anexo = new Anexo();
				$zip = new ZipArchive;
				$nome = "$id-anexo-".date('U');
				$zip->open(base_path()."/anexos/$nome.zip", ZipArchive::CREATE);
				mkdir(base_path()."/anexos/$nome");
				foreach($_FILES['anexo']['name'] as $key => $arquivos){
					#salva os arquivos enviados na resposta
					$ext = pathinfo($_FILES['anexo']['name'][$key])['extension'];
					$file = base_path()."/anexos/$nome/$nome($key).".$ext;
					move_uploaded_file($_FILES['anexo']['tmp_name'][$key],
						$file);
					$zip->addFile($file, "$nome(".($key+1).").$ext");
				}
				$zip->close();
				Self::delete_directory(base_path()."/anexos/$nome");
				$anexo->nome = "$nome.zip";
				$viagem->anexos()->save($anexo);
			}

			#create ou update de pessoa conforme o cpf
			$pessoa = $viagem->pessoa;
			$pessoa->update($dados['pessoa']);
			$pessoa->contato->update($dados['pessoa']['contato']);

			#cadastra a empresa caso a viagem seja organizada por uma
			if($dados['organizacao_id'] == 1){
				if($viagem->empresa){
					$viagem->empresa->update($dados['empresa']);
					$viagem->empresa->contato->update($dados['empresa']['contato']);
				}else{
					$contato_empresa = Contato::create($dados['empresa']['contato']);
					$empresa = new Empresa($dados['empresa']);
					$empresa->contato()->associate($contato_empresa)->save();
					$viagem->empresa()->associate($empresa);
				}
			}else
				$viagem->empresa()->delete();
			
			$viagem->update($dados);
			
			#salva os relacionamentos many to many da viagem
			MainHelper::manyToMany($viagem->tiposAtrativos(), $dados['tipoatrativo'], @$dados['especificar_atrativo']);
			MainHelper::manyToMany($viagem->tiposMotivos(), $dados['tipomotivo'], @$dados['especificar_motivo']);
			MainHelper::manyToMany($viagem->tiposRefeicoes(), $dados['tiporefeicao'], @$dados['especificar_refeicao']);
			MainHelper::manyToMany($viagem->tiposVisitantes(), $dados['tipovisitante'], @$dados['especificar_visitante']);
			MainHelper::manyToMany($viagem->tiposDestinos(), $dados['tipodestino'], @$dados['especificar_destino']);

			$params = [
				'texto'		=> "A edição da autorização de veículos é divido em duas partes. A segunda parte do formulário que é destinada para os veículos estará disponível no link acima, e é necessária para validar seu formulário.",
				'titulo'	=> 'Link para continuar a edição <a href="'.url("veiculo/$viagem->id/edit?hash=".$viagem->hash).'">aqui</a>',
				'to'		=> $viagem->pessoa->contato->email,
				'assunto'	=> 'Edição parcial - Autorização de veículos'
			];

			Mail::send('email.comunicar', ['dados' => $params], function($message) use($params){
				$message->subject($params['assunto']);
				$message->to($params['to']);
			});

		}catch(Exception $e){
			DB::rollback();
			return $e->getMessage();
			return Redirect::back()->withInput()->with('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.');
		}
		DB::commit();

		return Redirect::to("veiculo/$viagem->id/edit?hash=".$viagem->hash)->with('success', "Primeira etapa editada com sucesso.<br>Caso não seja possível efetuar a edição de veículos no momento, utilize esse link: <b>".url("veiculo/$viagem->id/edit?hash=".$viagem->hash)."</b>");
	}

	public function destroy($id){
		try {
			$viagem = Viagem::find($id);
			$viagem->delete();
		}catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->with('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.')->withInput();
		}
		DB::commit();
		return Redirect::back()->with('success','Viagem desativado com sucesso.');
	}

	public function listar($tipo){
		$dados = Input::all();
		$viagem = new Viagem;
				
		if($dados['status_id'])
			$viagem = $viagem->where('status_id',$dados['status_id']);

		if($dados['nome'] || $dados['cpf']){
			$viagem = $viagem->join('pessoas','pessoas.id','=','viagens.pessoa_id');
			$viagem = $viagem->where('pessoas.nome','LIKE',"%".$dados['nome']."%");
			$viagem = $viagem->where('pessoas.cpf','LIKE',"%".FormatterHelper::somenteNumeros($dados['cpf'])."%");
		}

		if($tipo == 'inativos')
			$viagem = $viagem->onlyTrashed();

		$elementos = $viagem->paginate(10);

		return View::make('viagem.table', compact('elementos'));
	}

	public function responder($id){
		$dados = Input::all();
		DB::beginTransaction();
		try{
			$resposta = new Resposta($dados);
			$nome = "";
			if(!empty($dados['anexo'])){
				$zip = new ZipArchive;
				$nome = "$id-resposta-".date('U');
				$zip->open(base_path()."/respostas/$nome.zip", ZipArchive::CREATE);
				mkdir(base_path()."/respostas/$nome");
				foreach($_FILES['anexo']['name'] as $key => $arquivos){
					#salva os arquivos enviados na resposta
					$ext = pathinfo($_FILES['anexo']['name'][$key])['extension'];
					$file = base_path()."/respostas/$nome/$nome($key).".$ext;
					move_uploaded_file($_FILES['anexo']['tmp_name'][$key],
						$file);
					$zip->addFile($file, "$nome(".($key+1).").$ext");
				}
				$zip->close();
				Self::delete_directory(base_path()."/respostas/$nome");
				$resposta->anexo = "$nome.zip";
			}
			$viagem = Viagem::find($id);
			$resposta = $viagem->respostas()->save($resposta);
			$viagem->status_id = $dados['tipo_resposta_id'] == 1 ? 3 : 4;
			$viagem->hash = Hash::make('hash');
			$viagem->update();
			$texto = $resposta->texto;
			$texto .= $dados['tipo_resposta_id'] == 1 ? ("<br><br>Para acessar a edição de cadastro clique <a href='".url("viagem/$viagem->id/edit?hash=$viagem->hash")."'>aqui</a>.") : "";

			$params = [
				'texto'		=> $texto,
				'titulo'	=> 'Resultado: '.TipoResposta::find($resposta->tipo_resposta_id)->nome,
				'to'		=> $viagem->pessoa->contato->email,
				'assunto'	=> 'Resposta ao pedido de autorização de veículos'
			];

			Mail::send('email.comunicar', ['dados' => $params], function($message) use($params, $nome){
				$message->subject($params['assunto']);
				if($nome != "")
					$message->attach(base_path()."/respostas/$nome.zip");
				$message->to($params['to']);
			});
		}catch(Exception $e){
			DB::rollback();
			return Redirect::back()->with('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.');
		}
		DB::commit();
		return Redirect::back()->with('success','Solicitação respondida com sucesso!');
	}

}
