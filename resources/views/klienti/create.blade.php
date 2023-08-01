@extends('layouts.app')

@section('content')
<div class="row justify-content-between">
    <div class="col-lg-3">
            <h2>Novi korisnik</h2>
    </div>
    <div class="col-lg-2 text-end">
        <a class="btn btn-outline-secondary" href="{{ route('roles.index') }}"> Nazad</a>
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

{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="row mb-3 p-3 shadow">
    <h2>Osnovni podaci</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="naziv"><strong>Naziv firme:</strong></label>
            <input class="form-control" id="naziv" name="naziv" placeholder="Naziv firme">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="pib"><strong>PIB:</strong></label>
            <input class="form-control" id="pib" name="pib" placeholder="PIB">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="maticni_broj"><strong>Matični broj:</strong></label>
            <input class="form-control" id="maticni_broj" name="maticni_broj" placeholder="Matični broj">
        </div>
    </div>
</div>


<div class="row mb-3 shadow p-3">
    <h2>Adresa</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="ulica"><strong>Ulica:</strong></label>
            <input class="form-control" id="ulica" name="ulica" placeholder="Ulica">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="broj_ulice"><strong>Broj ulice:</strong></label>
            <input class="form-control" id="broj_ulice" name="broj_ulice" placeholder="Broj ulice">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="postanski_broj"><strong>Poštanski broj:</strong></label>
            <input class="form-control" id="postanski_broj" name="postanski_broj" placeholder="Poštanski broj">
        </div>
    </div>
    <div class="w-100"></div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="mesto"><strong>Mesto:</strong></label>
            <input class="form-control" id="mesto" name="mesto" placeholder="Mesto">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="opstina"><strong>Opština:</strong></label>
            <input class="form-control" id="opstina" name="opstina" placeholder="Opština">
        </div>
    </div>
</div>


<div class="row mb-3 p-3 shadow">
    <h2>Odgovorno lice</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="ime"><strong>Pol:</strong></label>
            <select class="form-control" id="ime" name="ime">
                <option value="1">Muško</option>
                <option value="2">Žensko</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-5">
        <div class="form-group">
            <label for="ime"><strong>Ime:</strong></label>
            <input class="form-control" id="ime" name="ime" placeholder="Ime">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-5">
        <div class="form-group">
            <label for="prezime"><strong>Prezime:</strong></label>
            <input class="form-control" id="prezime" name="prezime" placeholder="Prezime">
        </div>
    </div>
    <div class="w-100"></div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="telefon"><strong>Telefon:</strong></label>
            <input class="form-control" id="telefon" name="telefon" placeholder="Telefon">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="email"><strong>E-Mail:</strong></label>
            <input class="form-control" id="email" name="email" placeholder="E-Mail">
        </div>
    </div>
</div>


<div class="row mb-3 p-3 shadow">
    <h2>Banka</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="banka_id"><strong>Banka:</strong></label>
            <input class="form-control" id="banka_id" name="banka_id" placeholder="Banka">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="broj_bankovog_racuna"><strong>Broj bankovog računa:</strong></label>
            <input class="form-control" id="broj_bankovog_racuna" name="broj_bankovog_racuna" placeholder="Broj bankovog računa">
        </div>
    </div>
</div>


<div class="row mb-3 p-3 shadow">
    <h2>Interni podaci</h2>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="pocetak_obrade"><strong>Početak obrade:</strong></label>
            <input class="form-control" type="date" id="pocetak_obrade" name="pocetak_obrade" placeholder="Početak obrade">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <label for="poreska_filijala_id "><strong>Poreska filijala:</strong></label>
            <input class="form-control" id="poreska_filijala_id " name="poreska_filijala_id " placeholder="Poreska filijala">
        </div>
    </div>
    <div class="w-100"></div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="cena"><strong>Cena:</strong></label>
            <div class="input-group mb-3">
                <input name="cena" type="number" class="form-control" placeholder="Cena" aria-label="cena" aria-describedby="cena">
                <span class="input-group-text" id="cena">%</span>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="prioritet "><strong>Prioritet:</strong></label>
            <select class="form-control" id="prioritet" name="prioritet">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 offset-md-6 align-self-end">
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Unesi</button>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection