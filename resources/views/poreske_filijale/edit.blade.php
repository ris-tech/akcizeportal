@extends('layouts.app')

@section('content')
<div class="row justify-content-between mb-5">
    <div class="col-lg-3">
        <h2>Promeni Poresku Filijalu</h2>
    </div>
    <div class="col-lg-2 text-end">
        <a class="btn btn-outline-secondary" href="{{ route('poreskafilijala.index') }}"> Nazad</a>
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

{!! Form::model($poreska_filijala, ['method' => 'PATCH','route' => ['poreskafilijala.update', $poreska_filijala->id]]) !!}
<div class="row mb-3 p-3 shadow">
    <h2>Osnovni podaci</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="ime"><strong>Ime Poreske Filijale:</strong></label>
            <input class="form-control" id="ime" name="ime" placeholder="Ime Poreske Filijale" value="{{$poreska_filijala->ime}}">
        </div>
    </div>
</div>


<div class="row mb-3 shadow p-3">
    <h2>Adresa</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="ulica"><strong>Ulica:</strong></label>
            <input class="form-control" id="ulica" name="ulica" placeholder="Ulica" value="{{$poreska_filijala->ulica}}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="broj_ulice"><strong>Broj ulice:</strong></label>
            <input class="form-control" id="broj_ulice" name="broj_ulice" placeholder="Broj ulice" value="{{$poreska_filijala->broj_ulice}}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="postanski_broj"><strong>Poštanski broj:</strong></label>
            <input class="form-control" id="postanski_broj" name="postanski_broj" placeholder="Poštanski broj" value="{{$poreska_filijala->postanski_broj}}">
        </div>
    </div>
    <div class="w-100"></div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="mesto"><strong>Mesto:</strong></label>
            <input class="form-control" id="mesto" name="mesto" placeholder="Mesto" value="{{$poreska_filijala->mesto}}">
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