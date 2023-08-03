@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Knjigovođa</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('banke.create') }}"> Unesi novu Banku</a>
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
     <th>Ime</th>
     <th width="280px">Opcije</th>
  </tr>
    @foreach ($banke as $banka)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $banka->ime }}</td>
        <td>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('banke.edit',$banka->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Promeni"><i class="fas fa-pencil-alt"></i></a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['banke.destroy', $banka->id],'style'=>'display:inline']) !!}
                    <button class="btn btn-danger show-alert-delete-box" type="submit"><i class="fas fa-trash-alt"></i></button>
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>

{!! $banke->render() !!}

@endsection