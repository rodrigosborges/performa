<!-- chamada do layout da página -->
@extends ("template.layout")
@section ("title","Usuários")<!-- Atribuição de titúlo p/ página -->

<!-- Inicio da Sessão de contéudo da página -->
@section("content")
<div class="card">
  <div class="card-header">
    <h4 class="text-center mb-4">Lista de {{$data['titulo']}}</h4>
    <ul class="nav nav-tabs nav-justified card-header-tabs">
      <li class="nav-item">
        <a data-toggle="tab" id="ativos-tab" href="#ativos" role="tab" aria-controls="ativos" aria-selected="true" class="nav-link active">Ativos</a>
      </li>
      <li class="nav-item">
        <a data-toggle="tab" id="inativos-tab" role="tab" aria-controls="inativos" aria-selected="false" class="nav-link" href="#inativos">Inativos</a>
      </li>
    </ul>    
  </div>

  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}">Início</a></li>
    <li class="breadcrumb-item active">Usuários</li>
  </ol>

  <div class="card-body tab-content">   
    <?= Form::open(array('url' => '', 'id' => 'filterform', 'method' => 'PUT')) ?>
      <div class="form-group mr-sm-2">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <span class="fas fa-search"></span>											
            </span>
          </div>
          @if($data['titulo'] == "Usuários Administrativos")
            <?= Form::text('usuario', null, array('class' => 'form-control required', 'placeholder' => 'Procurar por usuário')) ?>
          @else
            <?= Form::text('nome|documento', null, array('class' => 'form-control required', 'placeholder' => 'Procurar por nome ou documento')) ?>
          @endif
          <div class="input-group-append">
            <?= Form::submit('PESQUISAR', array('class' => 'btn btn-info', 'id' => 'pesquisabtn', 'disabled')) ?>					
          </div>
        </div>								
      </div>
    <?= Form::close() ?>		
    <!-- TAB-CONTENT DE ATIVOS -->    
    <div id="ativos" role="tabpanel" aria-labelledby="ativos-tab" class="tab-pane fade active show">
    </div>

    <!-- TAB-CONTENT DE INATIVOS -->
    <div id="inativos" role="tabpanel" aria-labelledby="inativos-tab" class="tab-pane fade">
    </div>

  </div>
</div>

@stop

@section('js')
<script type="text/javascript" src="{{asset('assets/js/modal.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#pesquisabtn").attr('disabled',false)
  })
  @if($data['titulo'] == "Usuários Administrativos")
    $(document).ready(function(){
      AtivosInativos('usuario')
    })
    $("#filterform").submit(function(e){
      e.preventDefault()
      AtivosInativos('usuario','filterform')
    })
  @else
    $("#filterform").submit(function(e){
      e.preventDefault()
      AtivosInativosPessoas('filterform')
    })
    $(document).ready(function(){
      AtivosInativosPessoas()
    })
    
    function AtivosInativosPessoas(form = null){
      function listagem(url,tipo,pessoa) {
        setLoading($('div#'+tipo))
        $.ajax({
          url: url+(url.indexOf('?') !== -1 ? "&" : "?")+$("#"+form).serialize(),
          success: function (data) {
            $('div#'+tipo).html(data)
          },
          error: function (jqXHR, exception) {
            $('div#'+tipo).html("<div class='alert alert-danger'>Desculpe, ocorreu um erro. <br> Recarregue a página e tente novamente</div>");
          },
        });
      }
      $(document).ready(function(){
        listagem(main_url+"usuario/listar/ativos/{{$data['tipo']}}",'ativos');
        listagem(main_url+"usuario/listar/inativos/{{$data['tipo']}}",'inativos');
  
        $('#ativos').on('click', 'ul.pagination a', function(e){
          e.preventDefault();
          listagem($(this).attr('href'),'ativos')
        })
  
        $('#inativos').on('click', 'ul.pagination a', function(e){
          e.preventDefault();
          listagem($(this).attr('href'),'inativos')
        })    
      })
    }
  @endif

</script>
@stop
