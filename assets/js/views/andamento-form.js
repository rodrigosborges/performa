$(document).ready(function(){
	var autocomplete = new Array;
	$.each(empresas,function(i,v){
		autocomplete.push(v.nome)
	})
	function checkedShow(checkbox, target) {
		if(checkbox.is(':checked')) {
			target.show();
		}else{
			target.hide();
		}
	}
	checkedShow($('#extrato'), $('div#empresas'));

	$("#extrato").change(function() {
		checkedShow($(this), $('div#empresas'));
	});
	

	$.each($('div.empresa'),function(){
		$(this).find('input').autocomplete({
	      source: autocomplete
	    });		
	})

	$(document).on('click', 'button.addCloned', function(){
        var formGroup = $(this).parents('div.cloned-main');
        var cloned = formGroup.find('div.cloned-div').first();
		cloned.clone().insertAfter(formGroup.find('div.cloned-div').last()).find("input").val("")
        formGroup.find('div.cloned-div').last().find('input').autocomplete({
	      source: autocomplete
		});
		recontar(formGroup.find('div.cloned-div'))		
    })

    $(document).on('click', 'button.delCloned', function(){
        var clonedParent = $(this).parents('div.cloned-main')

        if(clonedParent.find('div.cloned-div').length != 1)
            $(this).parents('div.cloned-div').remove();
			recontar($('div.cloned-div'))

    })
});
