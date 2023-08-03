@extends('layouts.app')

@section('content')
<div class="row justify-content-between">
    <div class="col-lg-3">
            <h2>Nova Banka</h2>
    </div>
    <div class="col-lg-2 text-end">
        <a class="btn btn-outline-secondary" href="{{ route('banke.index') }}"> Nazad</a>
    </div>
</div>
<hr>
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

{!! Form::open(array('route' => 'banke.store','method'=>'POST')) !!}
<div class="row mb-3 p-3 shadow">
    <h2>Osnovni podaci</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="ime"><strong>Ime Banke:</strong></label>
            <input class="form-control" id="ime" name="ime" placeholder="Ime Banke">
        </div>
    </div>
</div>
<div class="row mb-3 p-3 shadow">
    <div class="col-xs-12 col-sm-12 col-md-2 offset-md-10 align-self-end">
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Unesi</button>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection