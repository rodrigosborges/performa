$(document).ready(function(){
	var idUsuario = null;

	if($('#form').attr('data-usuario_id'))
		idUsuario = $('#form').attr('data-usuario_id');
	
	$('#form').validate({
		rules: {
			// DADOS PESSOAIS
			nome: {
				minlength: 3,
				maxlength: 70,
			},
			data_nascimento: {
				validaDataBR: true,
			},
			// DOCUMENTOS
			cpf: {
				verificaCPF: true,
				remote: main_url + 'unique/individuos/documento/null/'+idUsuario,
			},
			cnpj: {				
				cnpj: true,
				remote: main_url + 'unique/individuos/documento/null/'+idUsuario,
			},
			numero:{
				number:true,
			},
			// USUÁRIO
			email: {				
				email: true,
				remote: main_url + 'unique/usuarios/email/null/'+idUsuario,
			},
			usuario:{				
				remote: main_url + 'unique/usuarios/usuario/null/'+idUsuario,
			},
			password:{				
				regex: "^(?=(?:.*[a-zA-z]{1,}))(?=(?:.*[0-9]){1,})(?=(?:.*[!@#$%&*]){1,})(.{10,})$",
			},
			password_confirmation:{				
				equalTo : "input[name='password']"
			},		
		},
		messages:{
			password: {
				regex: 'Necessário mínimo 10 caracteres contendo letras, números e caracter especial.',
			}
		}
	})
})