<!-- chamada do layout da página -->
@extends ("template.login")

<!-- Inicio da Sessão de contéudo da página -->
@section("content")
<p class="text-justify text-muted" style="paddin:10px;">
  O link para alteração de senha será enviado no seu e-mail.
</p>
<?= Form::open(array('url' => 'usuario/solicitarSenha', 'id' => 'formReset')) ?>

<div class="form-group">
  <?= Form::label('usuario','Usuário')?>
  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text">
        <span class="fas fa-user"></span>
      </span>
    </div>
    <?= Form::text('usuario', null, array('class' => 'form-control required', 'id' => 'usuario'))?>
  </div>
  <?php echo $errors->first('usuario'); ?>
</div>
<div class="btn-group-vertical btn-block">
<?= Form::submit('Enviar', array('class' => 'btn btn-success')) ?>
<?= link_to(url('login'),'Voltar', array('class' => 'btn btn-outline-secondary')) ?>
</div>

<?= Form::close() ?>
@stop
