<?php

class ViagemController extends \BaseController {

	public function index(){
		return Cidade::find(1)->estado;
	}


	public function create(){
	}

	public function store(){
	}

	public function show($id){
	}

	public function edit($id){
	}

	public function update($id){
	}

	public function destroy($id){
	}


}
