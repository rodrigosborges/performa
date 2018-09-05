$(document).ready(function(){
    	
	$('#form').validate({
		rules: {
			"placa[]": {
				placa: true,
				unique_array_table: "placaveiculo",
			},
			"tipo_veiculo_id[]": {
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