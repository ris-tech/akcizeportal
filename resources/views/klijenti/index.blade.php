@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Klijenti</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('klijenti.create') }}"> Unesi novog klijenta</a>
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
     <th>PIB</th>
     <th>Knjigovodja</th>
     <th>Provizija</th>
     <th width="280px">Opcije</th>
  </tr>
    @foreach ($klijenti as $klijent)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $klijent->naziv }}</td>
        <td>{{ $klijent->pib }}</td>
        <td>{{ $klijent->knjigovodja }}</td>
        <td>{{ $klijent->cena }} %</td>
        <td>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('klijenti.edit',$klijent->id) }}">Edit</a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['klijenti.destroy', $klijent->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Izbriši', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>

{!! $klijenti->render() !!}

@endsection