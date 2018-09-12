<!-- chamada do layout da página -->
@extends ("template.layout")
@section ("title","Relatórios")<!-- Atribuição de titúlo p/ página -->

<!-- Inicio da Sessão de contéudo da página -->
@section("content")
<div class="card">
  <div class="card-header">
    <h4>Relatórios</h4>
  </div>

  <div class="card-body">
    <h4 class="section-title">Estatísticos</h4>
      <?= Form::open(array('url' => null, 'method' => 'GET', 'id' => 'form-estatisticos', 'target' => '_blank'));?>
      <div class="row">
        <div class="form-group col-md-12">
          <label>Tipo<span>*</span></label>
          <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <span class="fas fa-list"></span>
                </span>
              </div>
              <?= Form::hidden('tipo', 'estatisticos') ?>
              <?= Form::select('tipoestatistica', $data['tipos'], null, array('class' => 'form-control required') )?>
          </div>
          <?= $errors->first('tipoestatistica') ?>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-4">
          <label>De</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <span class="fas fa-calendar"></span>
              </span>
            </div>
            <?= Form::text('de', null, array('class' => 'form-control data', 'placeholder' => '00/00/0000')) ?>
          </div>
        </div>
        <div class="form-group col-md-4">
          <label>Até </label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <span class="fas fa-calendar"></span>
              </span>
            </div>
            <?= Form::text('ate', null, array('class' => 'form-control data', 'placeholder' => '00/00/0000')) ?>
          </div>
        </div>
        <div class="form-group col-md-4">
          <label>Tipo de filtro de data</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <span class="fas fa-list"></span>
              </span>
            </div>
            <?= Form::select('tipodata', ['1' => 'Cadastro','2' => 'Chegada'], null, array('class' => 'form-control')) ?>
          </div>
        </div>
      </div>
      <div class="text-center">
        <?= Form::submit('Gerar relatório', array('class' => 'btn btn-secondary'));?>
      </div>
      <?= Form::close() ?>

      <h4 class="section-title">Origem dos visitantes</h4>
      <?= Form::open(array('url' => null, 'method' => 'GET', 'id' => 'form-origem', 'target' => '_blank'));?>
      <div class="row">
        <div class="form-group col-md-12">
          <label>Estado<span>*</span></label>
          <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <span class="fas fa-list"></span>
                </span>
              </div>
              <?= Form::hidden('tipo', 'origem') ?>
              <?= Form::select('estado', $data['estados'], null, array('class' => 'form-control required') )?>
          </div>
          <?= $errors->first('estado') ?>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-4">
          <label>De</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <span class="fas fa-calendar"></span>
              </span>
            </div>
            <?= Form::text('de', null, array('class' => 'form-control data', 'placeholder' => '00/00/0000')) ?>
          </div>
        </div>
        <div class="form-group col-md-4">
          <label>Até </label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <span class="fas fa-calendar"></span>
              </span>
            </div>
            <?= Form::text('ate', null, array('class' => 'form-control data', 'placeholder' => '00/00/0000')) ?>
          </div>
        </div>
        <div class="form-group col-md-4">
          <label>Tipo de filtro de data</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <span class="fas fa-list"></span>
              </span>
            </div>
            <?= Form::select('tipodata', ['1' => 'Cadastro','2' => 'Chegada'], null, array('class' => 'form-control')) ?>
          </div>
        </div>
      </div>
      <div class="text-center">
        <?= Form::submit('Gerar relatório', array('class' => 'btn btn-secondary'));?>
      </div>
      <?= Form::close() ?>
  </div>
</div>
@stop

@section('js')
  <script type="text/javascript" src="{{asset('assets/js/validacao/relatorioValidator.js')}}"></script>
@stop