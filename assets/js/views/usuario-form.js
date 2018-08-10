$(document).ready(function(){
  mudaPessoa()
  $(document).on("change", "input[name=tipo]", function(){
    mudaPessoa();
  });
  function mudaPessoa(){    
    show = ($("input[name=tipo]:checked").val() == 1) ? $('div.pessoa-fisica') : $('div.pessoa-juridica')
    hidden = ($("input[name=tipo]:checked").val() == 1) ? $('div.pessoa-juridica') : $('div.pessoa-fisica')

    show.removeAttr('hidden').find('*').removeAttr('disabled').removeAttr('hidden');
    hidden.find('*').attr({disabled:'disabled',hidden:'hidden'});    
  }


  //---------------- ADICIONAR/ALTERAR TELEFONE -------------------//
  cloneTel = $('div.telefoneDiv').find('div.telefone').first().clone();

  var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },
  spOptions = {
    onKeyPress: function(val, e, field, options) {
      field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
  };

  $('input.telefone_numero').mask(SPMaskBehavior, spOptions).rules('add',{
    regex: /\(\d{2}\)\s\d{4,5}-?\d{4}/g,
  })

  $(document).on('click','.addTel', function() {
    $(this).parents('div.telefoneDiv').find('div.alert').remove();
    if ($('.tipo_telefone_id').length >= 4) {
      $('div.telefoneDiv').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
        '<strong>Atenção!</strong> Número máximo de telefones atingido.'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
        '<span aria-hidden="true">&times;</span>'+
        '</button>'+
        '</div>');

    }else{
      clonar(cloneTel.clone(), $('.telefone').last());

      recontar($(this).parents('div.telefoneDiv').find("div.telefone"), function(i,element) {
        element.find('input.telefone_numero').mask(SPMaskBehavior, spOptions).rules('add',{
          regex: /\(\d{2}\)\s\d{4,5}-?\d{4}/g,
        })
      });      
    }
  })

  $(document).on('click', '.delTel', function(){
    $(this).parents('div.telefoneDiv').find('div.alert').remove();
    if ($(this).parents('div.telefoneDiv').find("div.telefone").length != 1) {
      $(this).closest('.telefone').fadeOut('fast', function () {
        $(this).remove();
        recontar($(this).parents('div.telefoneDiv').find("div.telefone"));
      })
    }else{
      $('div.telefoneDiv').append('<div class="alert alert-info alert-dismissible fade show" role="alert">'+
        '<strong>Atenção!</strong> Necessário cadastro de um telefone p/ contato.'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
        '<span aria-hidden="true">&times;</span>'+
        '</button>'+
        '</div>');
    }
  })

})
