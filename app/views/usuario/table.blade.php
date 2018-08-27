
<p>{{$elementos->getTotal()}} Registro(s) encontrado(s).</p>
@if ($elementos->count())
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Usuário</th>
        <th>Email</th>
        <th>Tipo</th>
        <th>Ultima Modificação</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($elementos as $usuario):?>
        <tr>
          <td>{{$usuario->usuario}}</td>
          <td>{{$usuario->email}}</td>
          <td>{{$usuario->nivel->tipo}}</td>
          <td>{{$usuario->updated_at->format('H:i:s - d/m/Y')}}</td>
          <td>
            <div class="btn-group">
              @if($data['tipo'] == 'ativos')
              <a href="{{url('usuario/'.$usuario->id.'/edit')}}" class="btn btn-primary" title="Editar"><span class="fa fa-edit"></span></a>
              <a href="{{url('usuario/'.$usuario->id)}}" class="btn btn-danger delete-button" title="Desativar"><span class="fa fa-trash-alt"></span></a>
              @else
              <a href="{{url('usuario/'.$usuario->id.'/restore')}}" class="btn btn-success" title="Reativar">Reativar <span class="fa fa-check"></span></a>
              @endif
            </div>
          </td>
        </tr>
      <?php  endforeach;?>
    </tbody>
    <tfoot>
    <tr>
      <td colspan="100%" class="text-center">
        <p class="text-center">
          Página {{$elementos->getCurrentPage()}} de {{$elementos->getLastPage()}}
          - Exibindo {{$elementos->getPerPage()}} registro(s) por página de {{$elementos->getTotal()}}
          registro(s) no total
        </p>
      </td>     
    </tr>
    @if($elementos->getLastPage() > 1)
    <tr>
      <td colspan="100%">
        {{ $elementos->links() }}
      </td>
    </tr>
    @endif
  </tfoot>
  </table>
</div>
@endif