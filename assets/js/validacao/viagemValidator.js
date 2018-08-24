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
			//DATAS
			"chegada":{
				validaDataLivre: true,
				minDate: new Date(Date.now()).addDays(10).toLocaleString().slice(0,10),
			},
			"saida":{
				validaDataLivre: true,
				minDate: new Date(Date.now()).addDays(10).toLocaleString().slice(0,10),
				minDateCompare: 'chegada',
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
			"documentos[solicitante]": {
				extension: 'jpg|jpeg|png|pdf',
			}
		},
		messages:{}
	})
})