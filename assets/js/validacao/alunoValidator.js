$(document).ready(function(){
	var idpessoa = null;

	if($('#form').attr('data-pessoa_id'))
		idpessoa = $('#form').attr('data-pessoa_id');
	
	$('#form').validate({
		rules: {
			// DADOS PESSOAIS
			"nome": {
				minlength: 3,
				maxlength: 100,
			},
			// DOCUMENTOS
			"cpf": {
				verificaCPF: true,
			},
			//DATAS
			"data_nascimento":{
				validaDataLivre: true,
			},
			"dia_pagamento":{
				number: true,
				range: [1,31]
			},
			// CONTATO
			"email": {				
				email: true,
			},
			"telefone": {
				telefone:true,
			},
			"celular": {
				telefone:true,
			},
		},
		messages:{}
	})
})