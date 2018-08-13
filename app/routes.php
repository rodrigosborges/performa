<?php

Route::get('/', function(){
	return View::make('index');
});

// Route::get('/generate/models', '\\Jimbolino\\Laravel\\ModelBuilder\\ModelGenerator5@start');

Route::resource('viagem','ViagemController');