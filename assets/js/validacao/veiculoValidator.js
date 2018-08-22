$(document).ready(function(){
    	
	$('#form').validate({
		rules: {
            "registro[]":{

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