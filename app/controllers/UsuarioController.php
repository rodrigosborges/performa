<?php

class UsuarioController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		$data['titulo'] = "Usuários Administrativos";
		return View::make("usuario.index",compact('data'));
	}


	public function typePerson($tipo,$tipo_pessoa)
	{
		$dados = Input::except('page','_token','_method');

		$usuarios = Usuario::whereHas('individuo', function($query) use($dados,$tipo_pessoa){
			$query->where('tipo',$tipo_pessoa);
			if ($dados) {
				foreach($dados as $key => $dado){
					if($dado){
						$query->where(function($q)use($key,$dado){
							foreach(explode("|",$key) as $string){
								$q = $q->orWhere($string, 'LIKE', "%".($string == "documento" ? FormatterHelper::removeSignals($dado) : $dado)."%");
							}
						});
					}
				}
			}
		});

		if($tipo == 'inativos')
			$usuarios = $usuarios->onlyTrashed();

		$usuarios = $usuarios->paginate(10);

		return View::make('individuo.table',compact('usuarios','tipo','tipo_pessoa'));

	}

	public function individuos($tipo){
		$data = [
			'titulo' => $tipo ? "Pessoas Físicas" : "Pessoas Jurídicas",
			'tipo' => $tipo,
		];
		return View::make("usuario.index",compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data = [
			'url' => 'usuario/',
			'method'=>'POST',
		];
		return View::make("usuario.form",compact('data'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		if(empty($input['nivel_id'])){ $input['nivel_id']=1;}
		if(isset($input['cpf'])){ $input['cpf']= FormatterHelper::somenteNumeros( $input['cpf']);}else {
			$input['cnpj']= FormatterHelper::somenteNumeros( $input['cnpj']);
		}

		$validator = Validator::make($input, UsuarioValidator::rules(null,$input), UsuarioValidator::msgs());
		$validator->setAttributeNames(array('password' => 'senha', 'nivel_id' => 'tipo')); //ALTERAÇÃO P/ 'Nice name'

		if ($validator->passes()) {
			$input['password'] = Hash::make($input['password']);
			// START SESSION OF INSERT QUERIES
			DB::beginTransaction();
			try {
				$data = AssingHelper::assingUsuario($input);
				$usuario = new Usuario($input);
				if(Auth::guest()){
					$usuario->nivel_id = 4;
					$usuario->reset_pass = false;
				}

				$usuario->save();
				$individuo = New Individuo($data['individuo']);
				$individuo->usuario()->associate($usuario)->save();
				foreach ($data['telefones'] as $key => $telefone) {
					$data['telefones'][$key] = new Telefone($telefone);
				}
				$individuo->telefones()->saveMany($data['telefones']);
				$endereco= new Endereco($data['endereco']);
				$endereco->individuo()->associate($individuo)->save();

				LoggerHelper::log('Cadastro do usuário ID:'.$usuario->id.' - usuário: '.$usuario->usuario);
			} catch (\Exception $e) {
				DB::rollback();
				Session::flash('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
				Caso o erro persista, contate o suporte técnico.');
				return Redirect::back()->withInput();
			}
			DB::commit();

			Session::flash('success','Usuário cadastrado com sucesso.');
			if (Auth::check()) {
				return Redirect::to('usuario');
			}
			return Redirect::back();

		}else{
			$validator->getMessageBag()->setFormat('<label class="error">:message</label>');
			Session::flash('warning','Alguns campos são obrigatórios, favor preenche-los corretamente.');
			return Redirect::back()->withInput()->withErrors($validator);
		}
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if(Auth::user()->nivel_id > 2 && Auth::id() != $id)
			return Redirect::to('usuario/'.Auth::id().'/edit');
		$usuario = Usuario::withTrashed()->find($id);
		if($usuario){
			$data = AssingHelper::returnValues($usuario,$usuario->individuo->endereco->cidade->estado_id);
			$data += [
				'url' => 'usuario/'.$usuario->id,				
				'method'=>'PUT',
			];
			return View::make("usuario.form",compact('usuario','data'));
		}
		return UsuarioController::msgBack();
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		$usuario = Usuario::withTrashed()->find($id);

		if(empty($input['nivel_id'])){ $input['nivel_id']=$usuario->nivel_id;}
		if(isset($input['cpf'])){ $input['cpf']= FormatterHelper::somenteNumeros( $input['cpf']);}else {
			$input['cnpj']= FormatterHelper::somenteNumeros( $input['cnpj']);
		}
		$validator = Validator::make($input, UsuarioValidator::rules($usuario,$input), UsuarioValidator::msgs());
		$validator->setAttributeNames(array('nivel_id' => 'tipo')); //ALTERAÇÃO P/ 'Nice name'

		if ($validator->fails()) {
			$validator->getMessageBag()->setFormat('<label class="error">:message</label>');
			Session::flash('warning','Alguns campos são obrigatórios, favor preenche-los corretamente.');
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$data = AssingHelper::assingUsuario($input);
		DB::beginTransaction();
		try {
			$usuario->fill($input);
			$alter_usuario = $usuario->getDirty();
			LoggerHelper::log("Atualização do usuário ID: $usuario->id - Username: $usuario->usuario");
			// if (!empty($alter_usuario)) {
			// 	foreach ($alter_usuario as $campo => $alteracao) {
			// 		LoggerHelper::log('Atualização do usuário ID: '.$usuario->id.' | alterado campo "'.$campo.'" de "'.$anterior->$campo.'" para "'.$alteracao.'"');
			// 	}
			// }
			$usuario->update();
			$dados = AssingHelper::assingUsuario($input);
			$usuario->individuo->fill($dados['individuo'])->update();
			$usuario->individuo->endereco->fill($dados['endereco'])->update();
			$individuo = $usuario->individuo;
			foreach ($individuo->telefones as $offset => $telefone) {
				if (isset($data['telefones'][$offset])) {
					$telefone->fill($data['telefones'][$offset])->update();
				}else{
					LoggerHelper::log('Atualização do individuo ID: '.$individuo->id.' : Exclusão do telefone do individuo '.$individuo->id.' telefone numero ('.$telefone->ddd.')('.$telefone->numero.').');
					$telefone->delete();
				}
			}
			if (count($individuo->telefones) < count($data['telefones']) ) {
				foreach ($data['telefones'] as $offset => $telefone) {
					if (!isset($usuario->individuo->telefones[$offset])) {
						$tel = new Telefone($telefone);
						$tel->individuo()->associate($individuo)->save();
						LoggerHelper::log('Atualização do individuo ID: '.$individuo->id.' : Cadastro do telefone do individuo '.$individuo->id.' telefone numero ('.$tel->ddd.')('.$tel->numero.').');
					}
				}
			}

		} catch (\Exception $e) {
			DB::rollback();
			return $e->getMessage();
			Session::flash('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.');
			return Redirect::back()->withInput();
		}
		DB::commit();
		Session::flash('success','Usuário '.$usuario->usuario.' editado com sucesso.');
		if(Auth::user()->nivel_id > 2)
			return Redirect::back();

		return Redirect::to('usuario');

}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try {
			$usuario = Usuario::find($id);
			$usuario->delete();
			LoggerHelper::log('Desativado usuário ID:'.$usuario->id.' - NOME: '.$usuario->usuario);
		} catch (\Exception $e) {
			DB::rollback();
			Session::flash('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.');
			return Redirect::back()->withInput();
		}
		DB::commit();
		Session::flash('success','Usuário desativado com sucesso.');
		return Redirect::back();
	}

	public function password($id){
		if(($id==Auth::user()->id)&&(Auth::user()->nivel_id == true)){
			$usuario = Usuario::find($id);
			$data = [
				'url' => 'reset/password/'.$usuario->id
			];
			return View::make("usuario.password",compact('usuario','data'));
		}
		return Redirect::to('/');
	}

	public function resetPass($tipo,$id){
		$input = Input::all();
		$input['reset_pass'] = true;
		$redirect = Redirect::to('usuario/'.$id.'/edit');

		if($tipo == 'reset'){
			$input['reset_pass'] = false;
			$redirect = Redirect::to('/');
		}

		$validator = Validator::make($input, UsuarioValidator::passRules(), UsuarioValidator::msgs());
		$validator->setAttributeNames(array('password'=>'senha', 'CheckPass'=>'confirma senha'));
		if ($validator->passes()) {
			$usuario = Usuario::find($id);
			$input['password'] = Hash::make($input['password']);

			$usuario->fill($input)->update();
			LoggerHelper::log('Alterada senha do usuário número '.$usuario->id.' nome '.$usuario->usuario);
			return $redirect->with('success','Senha alterada com sucesso!');
		}
		Session::flash('modal_show',1);
		$validator->getMessageBag()->setFormat('<label class="error">:message</label>');
		return Redirect::back()->withErrors($validator);
	}


	public static function sendEmail($usuario, $assunto){
		Mail::send('emails.reset', ['usuario'=>$usuario, 'assunto' => $assunto] ,function($message)use($usuario,$assunto){
			$message->subject("E-Licitações - ".$assunto);
			$message->to($usuario->email, $usuario->usuario);
			$message->cc("rodrigo.borges@caraguatatuba.sp.gov.br","SISTEMAS");
		});
	}

	public function solicitacaoSenha(){
		return View::make("usuario.senhaEmail");
	}


	public function solicitarSenha(){
		$input = Input::all();
		$usuario = Usuario::where('usuario',$input['usuario'])->first();
		if($usuario){
			try {
				$usuario->novoToken();
				$usuario->reset_pass = 0;
				$usuario->update();
				Mail::send('emails.reset', ['usuario'=> $usuario ], function($message) use($usuario){
					$message->subject("E-Licitações - Solicitação de nova senha");
					$message->to($usuario->email, $usuario->usuario);
				});
			} catch (\Exception $e) {
				Session::flash('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
				Caso o erro persista, contate o suporte técnico.');
				return Redirect::back()->withInput();
			}
			LoggerHelper::log('Solicitado reset de senha do usuario '.$usuario->id.' nome '.$usuario->usuario);
			Session::flash('success',"O link para resetar a senha foi enviado para o e-mail ".$usuario->email);
			return Redirect::back();
		}
		$usuario = Usuario::onlyTrashed()->where('usuario',$input['usuario'])->first();
		if ($usuario) {
			LoggerHelper::log('Tentetiva de reset de senha do usuario DESATIVADO id '.$usuario->id.' nome '.$usuario->usuario);
			Session::flash('warning','O usuário encontra-se desativado');
		}else {
			Session::flash('warning','Não foi encontrado usuário de acordo com a busca informada.');
		}
		return Redirect::back();
	}


	public function mudarSenha(){
	    $usuario = Usuario::where('remember_token', '=', Input::get('rt'))->first();

	    if(!is_null($usuario)){
			$data = [
				'url' => 'usuario/atualizarSenha'
			];
	        return View::make('usuario.password',compact('data'));
	    } else {
	        return Redirect::to('login')->with('error','O código para lembrança expirou ou é inválido, por favor, faça uma nova solicitação de troca de senha');
	    }
	}


	public function atualizarSenha(){
		DB::beginTransaction();
		try{
		    $dados = Input::all();
			$usuario = Usuario::where('remember_token', '=', Input::get('remember_token'))->first();
			if($usuario != null){
				$validator = Validator::make($dados, UsuarioValidator::passRules(), UsuarioValidator::msgs());
				if($validator->fails()){
					$errors = $validator->errors()->all();
					return Redirect::back()->with('validation_error', $errors)
							->with(Input::flash());
				}
				$usuario->password = Hash::make($dados['password']);
				$usuario->novoToken();
				$usuario->update();
				DB::commit();
				return Redirect::to('/login')->withSuccess('Senha alterada com sucesso!');
			} else {
				return Redirect::to('/login')->with('error','O código para lembrança expirou, por favor, faça uma nova solicitação de troca de senha');
			}
		}catch (\Exception $e) {
            DB::rollback();
            Session::flash('_old_input', Input::all());
            return Redirect::back()->with('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.');
        }
	}

}
