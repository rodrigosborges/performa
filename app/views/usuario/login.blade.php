<!-- chamada do layout da página -->
@extends ("template.login")
<!-- Inicio da Sessão de contéudo da página -->
@section("content")
<div class="alert alert-info">
  Caro usuário(a), caso não consiga realizar o login, favor utilizar o "esqueci minha senha".
</div>
<?= Form::open(array('url' => 'login', 'id' => 'form'))?>
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

<div class="form-group">
  <?= Form::label('password','Senha')?>  
  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text">
        <span class="fas fa-key"></span>
      </span>
    </div>
    <?= Form::password('password', array('class' => 'form-control required', 'id' => 'password'))?>    
  </div>
  <?php echo $errors->first('password'); ?>  
</div>

<?= Form::submit('LOGIN', array('class' => 'btn btn-success btn-block btn-lg mb-3','id' => 'submit-login')) ?>

<?= Form::close() ?>  
<div class="form-group text-right" id="solicitarSenha">
  {{ link_to('usuario/solicitarSenha','Esqueceu sua senha?') }}
</div>
@stop
