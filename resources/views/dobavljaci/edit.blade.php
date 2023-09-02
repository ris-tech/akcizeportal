@extends('layouts.app')

@section('content')
<div class="row justify-content-between mb-5">
    <div class="col-md-3">
        <h2>Promeni dobavljača</h2>
    </div>
    <div class="col-md-2 text-end">
        <a class="btn btn-outline-secondary" href="{{ route('dobavljaci.index') }}"> Nazad</a>
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
{!! Form::model($dobavljaci, ['method' => 'PATCH','route' => ['dobavljaci.update', $dobavljaci->id]]) !!}
<div class="row mb-3 p-3 shadow">
    <h2>Dobavljač</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="ime"><strong>Naziv:</strong></label>
            <input class="form-control" id="ime" name="ime" placeholder="Naziv dobavljača" value="{{ $dobavljaci->ime }}">
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