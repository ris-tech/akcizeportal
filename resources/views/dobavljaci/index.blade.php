@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Dobavljači</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('dobavljaci.create') }}"> Unesi novog Dobavljača</a>
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
     <th>Dobavljač</th>
     <th width="280px">Opcije</th>
  </tr>

    @foreach ($dobavljaci as $dobavljac)
    
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $dobavljac->ime }}</td>
        <td>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('dobavljaci.edit',$dobavljac->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Promeni"><i class="fas fa-pencil-alt"></i></a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['dobavljaci.destroy', $dobavljac->id],'style'=>'display:inline']) !!}
                    <button class="btn btn-danger show-alert-delete-box" type="submit" data-bs-toggle="tooltip" data-bs-title="Izbriši"><i class="fas fa-trash-alt"></i></button>
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    
    @endforeach
</table>
@endsection