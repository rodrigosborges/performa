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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
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
	public function store(){
		$input = Input::all();


		$validator = Validator::make($input, UsuarioValidator::rules(null,$input), UsuarioValidator::msgs());
		$validator->setAttributeNames(array('password' => 'senha')); //ALTERAÇÃO P/ 'Nice name'

		if ($validator->passes()) {
			$input['password'] = Hash::make($input['password']);
			// START SESSION OF INSERT QUERIES
			DB::beginTransaction();
			try {
				$usuario = new Usuario($input);
				$usuario->save();
			} catch (\Exception $e) {
				DB::rollback();
				Session::flash('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
				Caso o erro persista, contate o suporte técnico.');
				return Redirect::back()->withInput();
			}
			DB::commit();

			return Redirect::to('/')->with('success','Usuário cadastrado com sucesso.');

		}else{
			$validator->getMessageBag()->setFormat('<label class="error">:message</label>');
			Session::flash('warning','Alguns campos são obrigatórios, favor preenche-los corretamente.');
			return Redirect::back()->withInput()->withErrors($validator);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		$usuario = Usuario::find($id);
		if($usuario){
			$data = [
				'url' => 'usuario/'.$usuario->id,				
				'method'=>'PUT'
			];
			return View::make("usuario.form",compact('usuario','data'));
		}else{
			return Redirect::back()->with('error','Edição de usuário não disponível');
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
		$input = Input::all();
		$usuario = Usuario::find($id);

		$validator = Validator::make($input, UsuarioValidator::rules($usuario,$input), UsuarioValidator::msgs());
		if ($validator->fails()) {
			return $validator->messages();
			$validator->getMessageBag()->setFormat('<label class="error">:message</label>');
			Session::flash('warning','Alguns campos são obrigatórios, favor preenche-los corretamente.');
			return Redirect::back()->withInput()->withErrors($validator);
		}
		DB::beginTransaction();
		try {
			$usuario->update($input);
		} catch (\Exception $e) {
			DB::rollback();
			return Redirect::back()->with('error','Desculpe, ocorreu um erro, favor tente novamente.<br>
			Caso o erro persista, contate o suporte técnico.')->withInput();
		}
		DB::commit();
		return Redirect::to('/')->with('success','Usuário '.$usuario->usuario.' editado com sucesso.');

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
		$usuario = Usuario::find($id);
		if($id != Auth::id())
			return Redirect::back()->with('error','Troca de password permitida somente em sua conta');
		$data = [
			'url' => 'reset/password/'.$usuario->id
		];
		return View::make("usuario.password",compact('usuario','data'));
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
			// LoggerHelper::log('Alterada senha do usuário número '.$usuario->id.' nome '.$usuario->usuario);
			return $redirect->with('success','Senha alterada com sucesso!');
		}
		Session::flash('modal_show',1);
		$validator->getMessageBag()->setFormat('<label class="error">:message</label>');
		return Redirect::back()->withErrors($validator);
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
					$message->subject("Turismo - Solicitação de nova senha");
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
