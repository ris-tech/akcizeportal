@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Knjigovođa</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('knjigovodja.create') }}"> Unesi novog knjigovođu</a>
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
    @foreach ($knjigovodje as $knjigovodja)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $knjigovodja->naziv }}</td>
        <td>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('knjigovodja.edit',$knjigovodja->id) }}">Edit</a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['knjigovodja.destroy', $knjigovodja->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Izbriši', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>

{!! $knjigovodje->render() !!}

@endsection