<?php

Route::group(array('before' => 'guest'),function(){
	Route::get('login','LoginController@index');
	Route::post('login', ['before' => 'login', 'uses' => 'LoginController@login']);
});

Route::group(array('before' => 'auth'), function(){
	Route::get('logout','LoginController@logout');
	Route::get('/', function(){ return View::make('index'); });
	Route::get('reset/password/{id}','UsuarioController@password');	Route::post('{tipo}/password/{id}','UsuarioController@resetPass');
	Route::resource('aluno','AlunoController');
	Route::resource('usuario','UsuarioController', array('only' => ['create','store','edit','update']));
	Route::get('aluno/listar/{tipo}', 'AlunoController@listar');
	Route::get('{model}/{id}/restore', 'BaseController@restore');
	Route::get('efetuarPagamento/{id}', 'AlunoController@efetuarPagamento');
});