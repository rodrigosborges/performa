<?php
//5.6.32
Route::group(array('before' => 'guest'),function(){
	Route::get('login','LoginController@index');
	Route::post('login', ['before' => 'login', 'uses' => 'LoginController@login']);

	Route::get('reset/password/{id}','UsuarioController@password');
	Route::post('{tipo}/password/{id}','UsuarioController@resetPass');

	//solicitação e troca de senha
	Route::get('usuario/solicitarSenha', 'UsuarioController@solicitacaoSenha');
	Route::post('usuario/solicitarSenha', 'UsuarioController@solicitarSenha');
	Route::post('usuario/atualizarSenha','UsuarioController@atualizarSenha');
	Route::get('usuario/atualizarSenha', 'UsuarioController@mudarSenha');
});

Route::resource('viagem','ViagemController', ['only' => ['create','store','edit','update']]);

Route::resource('veiculo','VeiculoController');

Route::get('findElements/{model}/{relacao}/{id}', 'QuerieHelper@findElements');

Route::group(array('before' => 'auth'), function(){
	Route::get('/', function(){ return View::make('index'); });
	Route::get('logout','LoginController@logout');
	Route::get('reset/password/{id}','UsuarioController@password');
	Route::resource('viagem','ViagemController', ['except' => ['create','store','edit','update']]);
	Route::post('{tipo}/password/{id}','UsuarioController@resetPass');
	Route::resource('usuario','UsuarioController', array('only' => ['create','store','edit','update']));
	Route::get('viagem/listar/{tipo}', 'ViagemController@listar');
	Route::post('viagem/responder/{id}','ViagemController@responder');
	Route::get('{model}/{id}/restore', 'BaseController@restore');
	Route::get('relatorios','RelatorioController@index');
	Route::get('autorizacao/{id}','ViagemController@autorizacao');
});
Route::get('download/{caminho}/{arquivo}','BaseController@download');


// Route::get('/generate/models', '\\Jimbolino\\Laravel\\ModelBuilder\\ModelGenerator5@start');