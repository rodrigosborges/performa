<!-- chamada do layout da página -->
@extends ("template.layout")
@section ("title","Cadastro de Usuário")<!-- Atribuição de titúlo p/ página -->

<!-- Inicio da Sessão de contéudo da página -->
@section("content")
<div class="card">
  <div class="card-header">
    <h4>{{isset($usuario)? 'Edição' : 'Cadastro'}} de Usuário
      @if(isset($usuario))
      <?= Form::button('Alterar Senha', array('class' => 'btn btn-default float-md-right', 'data-toggle' => 'modal', 'data-target' => '#passwordModal')) ?>
      @endif
    </h4>
  </div>

  <div class="card-body">
    <?= Form::open(array('url' => $data['url'], 'id' => 'form', 'method'=>$data['method'], 'data-usuario_id'=> isset($usuario)? $usuario->id : null)) ?>

    <div class="row">
      <div class="form-group">
        <label>Nome <span>*</span></label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <span class="fas fa-user"></span>
            </span>
          </div>
          <?= Form::text('nome',isset($usuario)? $usuario->individuo->nome : null,array('class' => 'form-control required','maxlength' => '200'))?>
        </div>
        <?= $errors->first('nome'); ?>
      </div>
      <div class="form-group col-md-{{(Usuario::showNivel((isset($usuario)? $usuario:null)) ?'8': '12')}}">
        <label>Usuário <span>*</span></label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <span class="fas fa-user"></span>
            </span>
          </div>
          <?= Form::text('usuario',isset($usuario)? $usuario->usuario :null,array('class' => 'form-control required','maxlength' => '70'))?>
        </div>
        <?= $errors->first('usuario'); ?>
      </div>

      <div class="form-group col-md-4">
        <label>Tipo <span>*</span></label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><span class="fa fa-list-alt"></span></span>
          </div>
          <?= Form::select('nivel_id', $data['niveis'], isset($usuario)? $usuario->nivel_id :null, array('class' => 'form-control required'));?>
        </div>
        <?= $errors->first('nivel_id'); ?>
      </div>

      <div class="form-group">
        <label>Email <span>*</span></label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><span class="fas fa-envelope" aria-hidden="true"></span></span>
          </div>
          <?= Form::text('email',isset($usuario)? $usuario->email :null,array('class' => 'form-control required', 'maxlength' => '50'))?>
        </div>
        <?= $errors->first('email'); ?>
      </div>

      @if(!isset($usuario))
      <div class="form-group">
        <label>Senha <span>*</span></label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <span class="fas fa-key"></span>
            </span>
          </div>
          <?= Form::password('password', array('class' => 'form-control required'))?>
        </div>
        <?= $errors->first('password'); ?>
      </div>
      @endif
    </div>

    <?= Form::submit(isset($usuario)?'Atualizar':'Cadastrar', array('class' => 'btn btn-success btn-block'));?>
    <?= Form::close() ?>

  </div> <!-- FIM DO CARD-BODY-->
</div><!-- FIM DO CARD-->

@if(isset($usuario))
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passwordModalLabel">Alterar senha de usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= Form::open(array('url' => 'altera/password/'.$usuario->id, 'id' => 'formNewPass')) ?>
        <div class="form-group" style="margin: 0px">
          {{$errors->first('password')}}
        </div>
        <div class="form-group">
          <label for="password">Nova Senha <span>*</span></label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <span class="fas fa-key"></span>
              </div>
            </div>
            <?= Form::password('password', array('class' => 'form-control required'))?>
          </div>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirmar Senha <span>*</span></label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <span class="fas fa-key"></span>
              </div>
            </div>
            <?= Form::password('password_confirmation', array('class' => 'form-control required'))?>
          </div>
        </div>        
      </div>
      <div class="modal-footer">
        <?= Form::button('Sair',array('class'=>'btn btn-outline-secondary', 'data-dismiss' => 'modal'))?>
        <?= Form::submit('Alterar', array('class' => 'btn btn-primary', 'id' => 'btn_alter'));?>
      </div>
    </div>
  </div>
</div>
@endif

@stop

@section("js")
<script type="text/javascript" src="{{asset('assets/js/validacao/usuarioValidator.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/validacao/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/views/usuario-form.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/estado_cidade.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#formNewPass').validate({
      rules: {
        password:{        
          regex: "^(?=(?:.*[a-zA-z]{1,}))(?=(?:.*[0-9]){1,})(?=(?:.*[!@#$%&*]){1,})(.{10,})$",
        },
        password_confirmation:{       
          equalTo : "input[name='password']"
        },
      },
      messages:{
        password: {
          regex: 'Necessário mínimo 10 caracteres contendo letras, números e caracter especial.',
        }
      }
    });
  })
  $("#estado").change(function(){
    findElements($("#estado").val(),$("#cidade_id"),"Estado","cidades", null);
  })

  var cidade = "{{isset($usuario) ? $usuario->individuo->endereco->cidade_id : Input::old('cidade_id') }}";
  if(cidade){
    findElements($("#estado").val(),$("#cidade_id"),"Estado","cidades",cidade);
  }
</script>

@if(Session::get('modal_show'))
<script type="text/javascript">
  $('#passwordModal').modal('show');
</script>
@endif
@stop
