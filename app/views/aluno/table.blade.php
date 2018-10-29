<p>{{$elementos->getTotal()}} Registro(s) encontrado(s).</p>
@if ($elementos->count())
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Situação</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($elementos as $aluno)
        <tr>
            <td>{{$aluno->nome}}</td>
            <td>{{$aluno->cpf}}</td>
            <td>{{$aluno->situacao()}}</td>
            <td>
            <div class="btn-group">
                @if($aluno->trashed())
                    <a href="{{url('aluno/'.$aluno->id.'/restore')}}" class="btn btn-success" title="Desativar">Restaurar</a>
                @else
                    <a href="{{url('aluno/'.$aluno->id)}}" class="btn btn-success" title="Ver"><span class="fa fa-arrow-right"></span></a>
                    @if($aluno->status_id == 1)
                        <a href="{{url('veiculo?hash='.$aluno->hash)}}" class="btn btn-warning" title="Ver"><span class="fa fa-edit"></span></a>
                    @elseif($aluno->status_id == 3)
                        <a href="{{url('veiculo/'.$aluno->id.'/edit?hash='.$aluno->hash)}}" class="btn btn-warning" title="Ver"><span class="fa fa-edit"></span></a>
                    @endif
                    <a href="{{url('aluno/'.$aluno->id)}}" class="delete-button btn btn-danger" title="Desativar"><span class="fa fa-trash-alt"></span></a>
                @endif
            </div>
            </td>
        </tr>
        @endforeach
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