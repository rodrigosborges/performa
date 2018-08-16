$(document).ready(function(){
	var idViagem = null;

	if($('#form').attr('data-viagem_id'))
		idViagem = $('#form').attr('data-viagem_id');
	
	$('#form').validate({
		rules: {
			// DADOS PESSOAIS
			"pessoa[nome]": {
				minlength: 3,
				maxlength: 100,
			},
			// DOCUMENTOS
			"pessoa[cpf]": {
				verificaCPF: true,
			},
			// CONTATO
			"pessoa[contato][email]": {				
				email: true,
				// remote: main_url + 'unique/usuarios/email/null/'+idViagem,
			},
			"pessoa[contato][telefone]": {
				telefone:true,
			},
			"pessoa[contato][celular]": {
				telefone:true,
			},
			"empresa[contato][email]": {
				email:true,
			},
			"empresa[contato][telefone]": {
				telefone:true,
			},
			"placa[]": {
				placa: true,
			},
			"documentos[solicitante]": {
				multiple_extensions: 'jpg|jpeg|png|pdf',
			},
			"documentos[veiculo][]": {
				multiple_extensions: 'jpg|jpeg|png|pdf',
			},
			"documentos[regularidade][]": {
				multiple_extensions: 'jpg|jpeg|png|pdf',
			}

		},
		messages:{}
	})
})