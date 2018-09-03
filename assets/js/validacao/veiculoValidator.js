$(document).ready(function(){
    	
	$('#form').validate({
		rules: {
            "registro[]":{
				has_added: "veiculotable",
            },
			"placa[]": {
				placa: true,
				has_added: "veiculotable",
				unique_array_table: "placaveiculo",
			},
			"tipo_veiculo_id[]": {
				has_added: "veiculotable",
			},
			"documentos[veiculo][]": {
				multiple_extensions: 'jpg|jpeg|png|pdf',
				has_added: "veiculotable",
			},
			"documentos[regularidade][]": {
				multiple_extensions: 'jpg|jpeg|png|pdf',
				has_added: "veiculotable",
			}
		},
		messages:{}
    })
})