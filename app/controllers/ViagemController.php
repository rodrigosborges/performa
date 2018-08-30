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
			$viagem->hash = Hash::make(123);
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

		}catch(Exception $e){
			DB::rollback();
			return Redirect::back()->with('error','Erro no servidor');
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

	public function edit($id){}

	public function update($id){}

	public function destroy($id){}

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
			$zip = new ZipArchive;
			$nome = "$id-".date('dmY-His');
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
			$viagem = Viagem::find($id);
			$resposta = $viagem->respostas()->save($resposta);
			$viagem->status_id = $dados['tipo_resposta_id'] == 1 ? 3 : 4;
			$viagem->update();

			$params = [
				'texto'		=> $resposta->texto,
				'titulo'	=> 'Resultado: '.TipoResposta::find($resposta->tipo_resposta_id)->nome,
				'to'		=> $viagem->pessoa->contato->email,
				'assunto'	=> 'Resposta ao pedido de autorização de veículos'
			];

			Mail::send('email.comunicar', ['dados' => $params], function($message) use($params, $nome){
				$message->subject($params['assunto']);
				$message->attach(base_path()."/respostas/$nome.zip");
				$message->to($params['to']);
			});
		}catch(Exception $e){
			DB::rollback();
			return Redirect::back()->with('error','Erro no servidor');
		}
		DB::commit();
		return Redirect::back()->with('success','Solicitação respondida com sucesso!');
	}

}
