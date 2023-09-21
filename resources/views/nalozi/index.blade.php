@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Nalozi</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('nalozi.create', ['id' => $id]) }}"> Keiraj novi nalog</a>
            @endcan
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div>
@endif

<table class="table table-bordered">
  <tr>
     <th>Godina</th>
     <th>Kvartal</th>
     <th>Gorivo</th>
     <th>Skeneri</th>
     <th>Unosilac</th>
     <th width="280px">Opcije</th>
  </tr>
    @foreach ($nalozi as $nalog)
    <tr>
        <td>{{ $nalog->kvartal->godina }}</td>
        <td>{{ $nalog->kvartal->kvartal }}</td>
        <td>@if($nalog->eurodizel)<span class="badge bg-secondary">EURO DIZEL</span>@endif @if($nalog->tng)<span class="badge bg-secondary">TNG</span>@endif</td>
        <td>
            <table class="table table-striped">
                <tr>
                    <td><strong>Ulazne fakture:</strong></td>
                    <td>{{ $nalog->skener_ulazne_fakture->name }}</td>
                </tr>
                <tr>
                    <td><strong>Izlazne fakture:</strong></td>
                    <td>{{ $nalog->skener_izlazne_fakture->name }}</td>
                </tr>
                <tr>
                    <td><strong>Izvodi:</strong></td>
                    <td>{{ $nalog->skener_izvodi->name }}</td>
                </tr>
                <tr>
                    <td><strong>Kompenzacije:</strong></td>
                    <td>@if($nalog->skener_kompenzacije != NULL) {{ $nalog->skener_kompenzacije->name }} @else Nema @endif</td>
                </tr>
                <tr>
                    <td><strong>Knjižna odobrenja:</strong></td>
                    <td>@if($nalog->skener_knjizna_odobrenja != NULL) {{ $nalog->skener_knjizna_odobrenja->name }} @else Nema @endif</td>
                </tr>
            </table>
        </td>
        <td>{{ $nalog->unosilac->name }}</td>
        <td>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('nalozi.edit',$nalog->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Promeni"><i class="fas fa-pencil-alt"></i></a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['nalozi.destroy', $nalog->id],'style'=>'display:inline']) !!}
                    <input type="hidden" name="klijent_id" value="{{$id}}">
                    <button class="btn btn-danger show-alert-delete-box" type="submit" data-bs-toggle="tooltip" data-bs-title="Izbriši"><i class="fas fa-trash-alt"></i></button>
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>
@endsection