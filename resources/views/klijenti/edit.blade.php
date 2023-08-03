@extends('layouts.app')

@section('content')
<div class="row justify-content-between mb-5">
    <div class="col-md-3">
        <h2>Promeni Klijenta</h2>
    </div>
    <div class="col-md-2 text-end">
        <a class="btn btn-outline-secondary" href="{{ route('klijenti.index') }}"> Nazad</a>
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

{!! Form::model($klijenti, ['method' => 'PATCH','route' => ['klijenti.update', $klijenti->id]]) !!}
<div class="row mb-3 p-3 shadow">
    <h2>Osnovni podaci</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="naziv"><strong>Naziv firme:</strong></label>
            <input class="form-control" id="naziv" name="naziv" placeholder="Naziv firme" value="{{ $klijenti->naziv }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="pib"><strong>PIB:</strong></label>
            <input class="form-control" id="pib" name="pib" placeholder="PIB" value="{{ $klijenti->pib }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="maticni_broj"><strong>Matični broj:</strong></label>
            <input class="form-control" id="maticni_broj" name="maticni_broj" placeholder="Matični broj" value="{{ $klijenti->maticni_broj }}">
        </div>
    </div>
</div>


<div class="row mb-3 shadow p-3">
    <h2>Adresa</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="ulica"><strong>Ulica:</strong></label>
            <input class="form-control" id="ulica" name="ulica" placeholder="Ulica" value="{{ $klijenti->ulica }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="broj_ulice"><strong>Broj ulice:</strong></label>
            <input class="form-control" id="broj_ulice" name="broj_ulice" placeholder="Broj ulice" value="{{ $klijenti->broj_ulice }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="postanski_broj"><strong>Poštanski broj:</strong></label>
            <input class="form-control" id="postanski_broj" name="postanski_broj" placeholder="Poštanski broj" value="{{ $klijenti->postanski_broj }}">
        </div>
    </div>
    <div class="w-100"></div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="mesto"><strong>Mesto:</strong></label>
            <input class="form-control" id="mesto" name="mesto" placeholder="Mesto" value="{{ $klijenti->mesto }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="opstina"><strong>Opština:</strong></label>
            <input class="form-control" id="opstina" name="opstina" placeholder="Opština" value="{{ $klijenti->opstina }}">
        </div>
    </div>
</div>


<div class="row mb-3 p-3 shadow">
    <h2>Odgovorno lice</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="pol"><strong>Pol:</strong></label>
            <select class="form-control" id="pol" name="pol">
                <option value="1" {{ "1" === $odgovorno_lice->pol ? 'selected' : '' }}>Muško</option>
                <option value="2" {{ "2" === $odgovorno_lice->pol ? 'selected' : '' }}>Žensko</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="form-group">
            <label for="ime"><strong>Ime:</strong></label>
            <input class="form-control" id="ime" name="ime" placeholder="Ime" value="{{ $odgovorno_lice->ime }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="form-group">
            <label for="prezime"><strong>Prezime:</strong></label>
            <input class="form-control" id="prezime" name="prezime" placeholder="Prezime" value="{{ $odgovorno_lice->prezime }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="jmbg"><strong>JMBG:</strong></label>
            <input class="form-control" id="jmbg" name="jmbg" placeholder="JMBG" value="{{ $odgovorno_lice->jmbg }}">
        </div>
    </div>
    <div class="w-100"></div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="telefon"><strong>Telefon:</strong></label>
            <input class="form-control" id="telefon" name="telefon" placeholder="Telefon" value="{{ $odgovorno_lice->telefon }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="email"><strong>E-Mail:</strong></label>
            <input class="form-control" id="email" name="email" placeholder="E-Mail" value="{{ $odgovorno_lice->email }}">
        </div>
    </div>
</div>


<div class="row mb-3 p-3 shadow">
    <h2>Banka</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="banka_id"><strong>Banka:</strong></label>
            <select name="banka_id" class="form-select" id="banka_id">
                <option value="" selected disabled>Izaberi</option>
                @foreach($banke as $banka)
                    <option value="{{$banka->id}}" {{ $banka->id === $klijenti->banka_id ? 'selected' : '' }}>{{$banka->ime}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="broj_bankovog_racuna"><strong>Broj bankovog računa:</strong></label>
            <input class="form-control" id="broj_bankovog_racuna" name="broj_bankovog_racuna" placeholder="Broj bankovog računa" value="{{ $klijenti->broj_bankovog_racuna }}">
        </div>
    </div>
</div>


<div class="row mb-3 p-3 shadow">
    <h2>Interni podaci</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="poreska_filijala_id "><strong>Poreska filijala:</strong></label>
            <select name="poreska_filijala_id" class="form-select" id="poreska_filijala_id">
                <option value="" selected disabled>Izaberi</option>
                @foreach($poreska_filijala as $filijala)
                    <option value="{{$filijala->id}}" {{ $filijala->id === $klijenti->poreska_filijala_id ? 'selected' : '' }}>{{$filijala->ime}} - {{$filijala->ulica}} {{$filijala->broj_ulice}} | {{$filijala->postanski_broj}} {{$filijala->mesto}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="knjigovodja_id "><strong>Knjigovođa:</strong></label>
            <select name="knjigovodja_id" class="form-select" id="knjigovodja_id">
                <option value="" selected disabled>Izaberi</option>
                @foreach($knjigovodja as $kv)
                    <option value="{{$kv->id}}" {{ $kv->id === $klijenti->knjigovodja_id ? 'selected' : '' }}>{{$kv->naziv}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="w-100"></div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="pocetak_obrade"><strong>Početak obrade:</strong></label>
            <input class="form-control" type="date" id="pocetak_obrade" name="pocetak_obrade" placeholder="Početak obrade" value="{{ $klijenti->pocetak_obrade }}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="cena"><strong>Cena:</strong></label>
            <div class="input-group mb-3">
                <input name="cena" type="number" class="form-control" placeholder="Cena" aria-label="cena" aria-describedby="cena" value="{{ $klijenti->cena }}">
                <span class="input-group-text" id="cena">%</span>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="prioritet "><strong>Prioritet:</strong></label>
            <select class="form-control" id="prioritet" name="prioritet">
                <option value="1" {{ "1" === $klijenti->prioritet ? 'selected' : '' }}>1</option>
                <option value="2" {{ "2" === $klijenti->prioritet ? 'selected' : '' }}>2</option>
                <option value="3" {{ "3" === $klijenti->prioritet ? 'selected' : '' }}>3</option>
                <option value="4" {{ "4" === $klijenti->prioritet ? 'selected' : '' }}>4</option>
                <option value="5" {{ "5" === $klijenti->prioritet ? 'selected' : '' }}>5</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 offset-md-10 align-self-end">
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Promeni</button>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection