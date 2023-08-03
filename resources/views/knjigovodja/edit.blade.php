@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Promeni knjigovođu</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('knjigovodja.index') }}"> Nazad</a>
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

{!! Form::model($knjigovodja, ['method' => 'PATCH','route' => ['knjigovodja.update', $knjigovodja->id]]) !!}
<div class="row mb-3 p-3 shadow">
    <h2>Osnovni podaci</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="naziv"><strong>Naziv knjigovođe:</strong></label>
            <input class="form-control" id="naziv" name="naziv" placeholder="Naziv knjigovođe" value="{{$knjigovodja->naziv}}">
        </div>
    </div>
    <div class="w-100"></div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="telefon"><strong>Telefon:</strong></label>
            <input class="form-control" id="telefon" name="telefon" placeholder="Telefon" value="{{$knjigovodja->telefon}}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="email"><strong>E-Mail:</strong></label>
            <input class="form-control" id="email" name="email" placeholder="E-Mail" value="{{$knjigovodja->email}}">
        </div>
    </div>
</div>


<div class="row mb-3 shadow p-3">
    <h2>Adresa</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="ulica"><strong>Ulica:</strong></label>
            <input class="form-control" id="ulica" name="ulica" placeholder="Ulica" value="{{$knjigovodja->ulica}}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="broj_ulice"><strong>Broj ulice:</strong></label>
            <input class="form-control" id="broj_ulice" name="broj_ulice" placeholder="Broj ulice" value="{{$knjigovodja->broj_ulice}}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="postanski_broj"><strong>Poštanski broj:</strong></label>
            <input class="form-control" id="postanski_broj" name="postanski_broj" placeholder="Poštanski broj" value="{{$knjigovodja->postanski_broj}}">
        </div>
    </div>
    <div class="w-100"></div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="mesto"><strong>Mesto:</strong></label>
            <input class="form-control" id="mesto" name="mesto" placeholder="Mesto" value="{{$knjigovodja->mesto}}">
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