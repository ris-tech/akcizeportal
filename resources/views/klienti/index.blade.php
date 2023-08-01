@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Klienti</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('klienti.create') }}"> Unesi novog klienta</a>
            @endcan
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<table class="table table-bordered">
  <tr>
     <th>No</th>
     <th>Name</th>
     <th width="280px">Action</th>
  </tr>
    @foreach ($klienti as $klient)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $klient->naziv }}</td>
        <td>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('klienti.edit',$role->id) }}">Edit</a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['klienti.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Izbriši', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>

{!! $klienti->render() !!}

@endsection