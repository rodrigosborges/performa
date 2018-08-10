$(document).ready(function(){
  var idLicitacao = null;
  if($('#form').attr('data-licitacao_id'))
		idLicitacao = $('#form').attr('data-licitacao_id');

  $('#form').validate({
    rules: {
      abertura:{
        validaDataLivre: true,
      },
      numero:{
        regex: '^[a-zA-z]{2}/[0-9]{3}/[0-9]{4}$',
        remote: main_url + 'unique/licitacoes/numero/null/'+idLicitacao,
      },
      processo:{
        regex: '^[0-9]{8}-[0-9]{1}/[0-9]{4}$',
      },
      publicacao:{
        validaDataLivre: true,
      },
      data_evento:{
        validaDataLivre: true,
      },
      'edital[]': {
        multiple_extensions: 'doc|docx|jpg|jpeg|png|dwg|xls|xlsx|pdf',
        files_size: '30000',
      },
    },
    messages: {
      numero: {
        remote: 'O número informado já está em uso.',
      },
    },
  });
});
