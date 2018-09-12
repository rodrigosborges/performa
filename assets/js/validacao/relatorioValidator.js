$(document).ready(function(){
	$('#form-estatisticos').validate({
		rules: {			
            "de":{
                validaDataLivre: true,
            },
            "ate":{
                validaDataLivre: true,
            },
		},
		messages:{}
    })
    $('#form-origem').validate({
		rules: {			
            "de":{
                validaDataLivre: true,
            },
            "ate":{
                validaDataLivre: true,
            },
		},
		messages:{}
    })
})