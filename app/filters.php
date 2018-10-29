<?php

App::before(function($request){
	function array_strip_tags($array){
		$result = array();
		foreach ($array as $key => $value) {
			$key = strip_tags($key);
			if (is_array($value))
				$result[$key] = array_strip_tags($value);
			else
				$result[$key] = strip_tags($value);
		}
		return $result;
	}
	Input::merge(array_strip_tags(Input::all()));
});

App::after(function($request, $response){
});

App::missing(function($exception){
    return Response::view('template.error404', array(), 404);
});

Route::filter('auth', function(){
	if (Auth::guest()){
		if (Request::ajax())
			return Response::make('Unauthorized', 401);
		else
			return Redirect::guest('login');
	}
});

Route::filter('auth.basic', function(){
	return Auth::basic();
});

Route::filter('guest', function(){
	if (Auth::check()) return Redirect::to('/');
});

Route::filter('csrf', function(){
	if (Session::token() !== Input::get('_token')){
		throw new Illuminate\Session\TokenMismatchException;
	}
});
