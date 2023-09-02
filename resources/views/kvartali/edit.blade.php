@extends('layouts.app')

@section('content')
<div class="row justify-content-between mb-5">
    <div class="col-md-3">
        <h2>Promeni kvartal</h2>
    </div>
    <div class="col-md-2 text-end">
        <a class="btn btn-outline-secondary" href="{{ route('kvartali.index') }}"> Nazad</a>
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
{!! Form::model($kvartali, ['method' => 'PATCH','route' => ['kvartali.update', $kvartali->id]]) !!}
<div class="row mb-3 p-3 shadow">
    <h2>Kvartali</h2>
    <hr>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <label for="godina"><strong>Godina:</strong></label>
            <input class="form-control" id="godina" name="godina" type="number" min="1900" max="2099" step="1" value="{{ $kvartali->godina }}" />
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <label for="kvartal"><strong>Kvartal:</strong></label>
            <input class="form-control" id="kvartal" name="kvartal" type="text" value="{{ $kvartali->kvartal }}" />
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <label for="od"><strong>Od:</strong></label>
            <input class="form-control" id="od" name="od" type="date" value="{{ $kvartali->od }}" />
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <label for="do"><strong>Do:</strong></label>
            <input class="form-control" id="do" name="do" type="date" value="{{ $kvartali->do }}" />
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