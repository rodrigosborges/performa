$(document).ready(function(){	
	$('#form').validate({
		rules:{
			nome: {
				maxlength: 255,
			},
		}
	})
})