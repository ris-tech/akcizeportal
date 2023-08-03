@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Promeni Banku</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('banke.index') }}"> Nazad</a>
        </div>
    </div>
</div>

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

{!! Form::model($banke, ['method' => 'PATCH','route' => ['banke.update', $banke->id]]) !!}
<div class="row mb-3 p-3 shadow">
    <h2>Osnovni podaci</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="ime"><strong>Ime Banke:</strong></label>
            <input class="form-control" id="ime" name="ime" placeholder="Ime Banke" value="{{$banke->ime}}">
        </div>
    </div>
</div>
<div class="row mb-3 p-3 shadow">
    <div class="col-xs-12 col-sm-12 col-md-2 offset-md-10 align-self-end">
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Promeni</button>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection