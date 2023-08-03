@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Poreske Filijale</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('poreskafilijala.create') }}"> Unesi novu Poresku Filijalu</a>
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
    @foreach ($poreske_filijale as $poreskafilijala)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $poreskafilijala->ime }}</td>
        <td>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('poreskafilijala.edit',$poreskafilijala->id) }}">Edit</a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['poreskafilijala.destroy', $poreskafilijala->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Izbriši', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>

{!! $poreske_filijale->render() !!}

@endsection