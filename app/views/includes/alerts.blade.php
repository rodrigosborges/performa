@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ Session::get('success') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{ Session::get('error') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if(Session::has('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  {{ Session::get('warning') }}
  @if(Session::has('listErrors'))
    <br>
    @foreach($errors->all() as $erro)
      <br>{{$erro}}
    @endforeach
  @endif
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if(Session::has('message'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  {{ Session::get('message') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif