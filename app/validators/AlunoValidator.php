<?php
Class AlunoValidator{

	public static function rules($id = null, $dados){
		$rules = [
            'nome'	                => 'required | min:3',
            'cpf'	                => "cpf | unique:alunos,cpf,$id",
            'email'	                => 'required | email',
            'telefone'	            => 'required',
            'celular'	            => 'required',
            'data_nascimento'       => 'required | date_format:d/m/Y',
            'dia_pagamento' 	    => 'required | numeric',
            'sexo'	                => 'required | boolean',
            'endereco'	            => 'required',
            'bairro'	            => 'required',
            'cidade'	            => 'required',
            'uf'	                => 'required',
            'matricula'	            => ($id ? "required|" : "")."unique:alunos,matricula,$id",
        ];
            
        return $rules;
    }

}
?>
