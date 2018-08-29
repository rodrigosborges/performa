<?php

Route::get('/', function(){
	return View::make('index');
});

Route::group(array('before' => 'guest'),function(){
	Route::get('login','LoginController@index');
	Route::post('login', ['before' => 'login', 'uses' => 'LoginController@login']);

	//solicitação e troca de senha
	Route::get('usuario/solicitarSenha', 'UsuarioController@solicitacaoSenha');
	Route::post('usuario/solicitarSenha', 'UsuarioController@solicitarSenha');
	Route::get('usuario/atualizarSenha', 'UsuarioController@mudarSenha');
	Route::post('usuario/atualizarSenha','UsuarioController@atualizarSenha');
});

Route::resource('viagem','ViagemController');

Route::resource('veiculo','VeiculoController');

Route::get('findElements/{model}/{relacao}/{id}', 'QuerieHelper@findElements');

Route::group(array('before' => 'auth'), function(){
	Route::get('logout','LoginController@logout');
	Route::get('reset/password/{id}','UsuarioController@password');
	Route::post('{tipo}/password/{id}','UsuarioController@resetPass');
	Route::resource('usuario','UsuarioController', array('only' => ['create','store','edit','update']));
	Route::get('viagem/listar/{tipo}', 'ViagemController@listar');
	Route::post('viagem/responder/{id}','ViagemController@responder');
});
Route::get('download/{caminho}/{arquivo}','BaseController@download');


// Route::get('/generate/models', '\\Jimbolino\\Laravel\\ModelBuilder\\ModelGenerator5@start');