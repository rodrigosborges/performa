$(document).ready(function(){
    	
	$('#form').validate({
		rules: {
            "registro[]":{
				has_multiple: true,
            },
			"placa[]": {
				placa: true,
				has_multiple: true,
				unique_array: true,
			},
			"tipo_veiculo_id[]": {
				has_multiple: true,
			},
			"documentos[veiculo][]": {
				multiple_extensions: 'jpg|jpeg|png|pdf',
				has_multiple: true,
			},
			"documentos[regularidade][]": {
				multiple_extensions: 'jpg|jpeg|png|pdf',
				has_multiple: true,
			}
		},
		messages:{}
    })
})