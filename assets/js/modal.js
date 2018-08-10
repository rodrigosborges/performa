$(".btn-modal").click(function (e) {
  var button = $(this),
      nome = button.data('nome');

      if(button.data('tipo')=="ativar"){
        var title = 'Deseja ativar o usuário <strong>'+nome+'</strong> ?',
            type = BootstrapDialog.TYPE_SUCCESS,
            msg  = '<p>Ao ativar, o usuário poderá realizar acesso ao sistema.</p>',
            btn_label = 'ATIVAR',
            btn_class = 'success',
            redirect = 'ativar/';
      }else if (button.data('tipo')=="desativar") {
        var title = 'Deseja desativar o usuário <strong>'+nome+'</strong> ?',
            type = BootstrapDialog.TYPE_WARNING,
            msg  = '<p>Ao desativar, o usuário não poderá mais realizar o acesso ao sistema.</p> <p><strong>ATENÇÃO!</strong> não serão excluidas as informações salvas e só poderá ser reativado pelo administrador.</p>',
            btn_label = 'DESATIVAR',
            btn_class = 'warning',
            redirect = 'desativar/';
     }else if (button.data('tipo')=="deletar") {
        var title = 'Deseja deletar o usuário <strong>'+nome+'</strong> ?',
            type = BootstrapDialog.TYPE_DANGER,
            msg  = '<p><strong>ATENÇÃO!</strong> Ao deletar, TODOS os dados referentes ao usuário serão excluidos de forma permanente. Sendo assim, não será mais possível realizar acesso e/ou visualiza-lo na lista de usuários.</p>',
            btn_label = 'DELETAR',
            btn_class = 'danger',
            redirect = 'deletar/';
    }
  BootstrapDialog.show({
    title: title,
    type: type,
    closable: true,
    draggable: false,
    message: msg,
    buttons: [{
        label:'FECHAR',
        action: function(dialogRef) {
          dialogRef.close();
        }
      },{
      label: btn_label,
      cssClass: 'btn btn-'+btn_class,
      action: function(){
        window.location.href = redirect+button.data('id');
      }
    }]
  });

});
