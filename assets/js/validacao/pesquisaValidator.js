$(document).ready(function(){
	$('#form').validate({
		rules: {			
            "de":{
                validaDataLivre: true,
            },
            "ate":{
                validaDataLivre: true,
            },
            "cpf":{
                verificaCPF: true,
            },
		},
		messages:{}
    })
})