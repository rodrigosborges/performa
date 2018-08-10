$(document).ready(function () {

  $.each($('div.endereco'), function(){
    mudaBairro($(this).find('.estado'),$(this).find('.cidade_id')); //AO CARREGAR A PÁGINA RODA A FUNÇÃO P/ SELEÇÃO DO BAIRRO
  })

  $(document).on('focusout', '.cep', function(){
    buscarEndereco($(this));
  })

  //ALTERAÇÃO DE ESTADO DE RESIDENCIA
  $(document).on('change', '.estado', function() {
    cidade = $(this).parents('div.endereco').find('.cidade_id').val("");
    mudaBairro($(this),cidade);
  });
  //ALTERAÇÃO DE CIDADE DE RESIDENCIA
  $(document).on('change', '.cidade_id', function(){
    $(this).parents('div.endereco').find(".bairro-input").val("");
    $(this).parents('div.endereco').find(".bairro-select").val("");
    mudaBairro($(this).parents('div.endereco').find('.estado'),$(this));
  });


  /**
  * Habilita ou desabilita os bairros de caraguatatuba
  * conforme o estado e cidade selecionada.
  * Bairros habilitados somente quando valores de
  * cidade/estado forem 10500 e 35 respectivamente
  * @param {object} estado elemento do select do estado
  * @param {object} cidade elemento onde será atribuido as cidades
  * @author Rafael Domingues Teixeira
  */
  function mudaBairro(estado,cidade){
    var divEndereco = estado.parents('div.endereco');
    divEndereco.find(".bairro-select").attr('disabled', 'disabled').hide();
    divEndereco.find(".bairro-input").removeAttr('disabled').show();

    if((cidade.val() !== "")&&(estado.val() == '35')) {
      $.get(main_url + "findElements/Cidade/id/" + cidade.val(), function (dataCidade) {
        if(dataCidade == '3388'){
          divEndereco.find(".bairro-input").attr('disabled', 'disabled').hide();
          divEndereco.find(".bairro-select").removeAttr('disabled').show();
        }
      });
    }
  }

  function selecionaBairro(cidade, bairroSelect, bairroInput, bairro){
    bairroSelect.attr('disabled', 'disabled').hide();
    bairroInput.removeAttr('disabled').show();
    if(cidade == 'Caraguatatuba'){
      bairroInput.attr('disabled', 'disabled').hide();
      bairroSelect.removeAttr('disabled').show();
      var opcaoEndereco = bairroSelect.find('option:contains('+removeAcento(bairro.toUpperCase())+')')
      if(opcaoEndereco.length){
        opcaoEndereco.prop('selected',true)
      }else{
        bairroSelect.find('option:contains(Selecione)').prop('selected',true)
      }
    }else{
      bairroInput.val(bairro.toUpperCase());
    }
  }
  
  function buscarEndereco(cep){
    var numb = cep.val().replace(/[^0-9.]/g, ""), divEndereco = cep.parents('div.endereco')
    if(numb.length == 8){
      $.ajax('https://viacep.com.br/ws/'+numb+'/json/unicode/').done((resposta) => {
        if(!resposta.erro){
          var cidade = divEndereco.find('.cidade_id')
          divEndereco.find('.estado').find('option:contains('+resposta.uf+')').prop('selected',true)
          findElements(divEndereco.find('.estado').val(), cidade, 'Estado', 'cidades', resposta.localidade)
          selecionaBairro(resposta.localidade,divEndereco.find(".bairro-select"),  divEndereco.find(".bairro-input"), resposta.bairro)
          divEndereco.find('.logradouro').val(resposta.logradouro)
          divEndereco.find('.numero').focus()
        }
      })
    }
  }

  function removeAcento (text){                                                            
    text = text.replace(new RegExp('[ÁÀÂÃ]','gi'), 'A');
    text = text.replace(new RegExp('[ÉÈÊ]','gi'), 'E');
    text = text.replace(new RegExp('[ÍÌÎ]','gi'), 'I');
    text = text.replace(new RegExp('[ÓÒÔÕ]','gi'), 'O');
    text = text.replace(new RegExp('[ÚÙÛ]','gi'), 'U');
    text = text.replace(new RegExp('[Ç]','gi'), 'C');
    return text;                 
}

});
