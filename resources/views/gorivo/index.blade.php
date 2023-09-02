@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Gorivo</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('gorivo.create') }}"> Unesi novo gorivo</a>
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
     <th>Gorivo</th>
     <th width="280px">Opcije</th>
  </tr>

    @foreach ($goriva as $gorivo)
    
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $gorivo->ime }}</td>
        <td>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('gorivo.edit',$gorivo->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Promeni"><i class="fas fa-pencil-alt"></i></a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['gorivo.destroy', $gorivo->id],'style'=>'display:inline']) !!}
                    <button class="btn btn-danger show-alert-delete-box" type="submit" data-bs-toggle="tooltip" data-bs-title="Izbriši"><i class="fas fa-trash-alt"></i></button>
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    
    @endforeach
</table>
@endsection