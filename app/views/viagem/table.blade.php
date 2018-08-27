<p>{{$elementos->getTotal()}} Registro(s) encontrado(s).</p>
@if ($elementos->count())
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Responsável</th>
            <th>Data de chegada</th>
            <th>Data de cadastro</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($elementos as $viagem)
        <tr>
            <td>{{$viagem->pessoa->nome}}</td>
            <td>{{$viagem->chegada}}</td>
            <td>{{$viagem->created_at}}</td>
            <td>
            <div class="btn-group">
                    <a href="{{url('viagem/'.$viagem->id)}}" class="delete-button btn btn-danger" title="Desativar"><span class="fa fa-trash-alt"></span></a>
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