<!-- chamada do layout da página -->
@extends ("template.login")

<!-- Inicio da Sessão de contéudo da página -->
@section("content")
    <?= Form::open(array('url' => $data['url'])) ?>

    <div class="input-container">
      {{$errors->first('password')}}
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
    </div>

    <div class="form-group">
      <?= Form::label('password_confirmation','Confirme a senha')?>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">
            <span class="fas fa-key"></span>
          </span>
        </div>
        <?= Form::password('password_confirmation', array('class' => 'form-control required', 'id' => 'password_confirmation'))?>
      </div>
    </div>
  
    @if(Input::get('rt'))
      <input type='hidden' name="remember_token" value="{{Input::get('rt')}}">
    @endif

    <?= Form::submit('Alterar', array('class' => 'btn btn-success btn-block btn-lg')) ?>

    <?= Form::close() ?>
  @stop
