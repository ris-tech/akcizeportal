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
                <a class="btn btn-primary" href="{{ route('klijenti.edit',$klijent->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Promeni"><i class="fas fa-pencil-alt"></i></a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['klijenti.destroy', $klijent->id],'style'=>'display:inline']) !!}
                    <button class="btn btn-danger show-alert-delete-box" type="submit"><i class="fas fa-trash-alt"></i></button>
                {!! Form::close() !!}
            @endcan
            @can('role-edit')
                <a href="{{ route('ugovor.edit',$klijent->id) }}" class="btn btn-secondary" type="submit"><i class="fas fa-file-signature"></i></button>
            @endcan
        </td>
    </tr>
    @endforeach
</table>
@endsection