@extends('layouts.app')

@section('content')
<div class="row justify-content-between">
    <div class="col-lg-3">
            <h2>Novi nalog</h2>
    </div>
    <div class="col-lg-2 text-end">
        <a class="btn btn-outline-secondary" href="{{ route('nalozi.index') }}"> Nazad</a>
    </div>
</div>
<hr>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Greška!</strong><br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
{!! Form::open(array('route' => 'nalozi.store','method'=>'POST')) !!}
<input type="hidden" name="klijent_id" value="{{$id}}">
<div class="row mb-3 p-3 shadow">
    <h2>Osnovni podaci</h2>
    <hr>
    <div class="col-xs-2 col-sm-2 col-md-2">
        <div class="form-group">
            <label for="godina"><strong>Godina:</strong></label>
            <select name="godina" class="form-select" id="godina">
                <option value="2018" @selected(old('godina') == '2018')>2018</option>
                <option value="2019" @selected(old('godina') == '2019')>2019</option>
                <option value="2020" @selected(old('godina') == '2020')>2020</option>
                <option value="2021" @selected(old('godina') == '2021')>2021</option>
                <option value="2022" @selected(old('godina') == '2022')>2022</option>
                <option value="2023" @selected(old('godina') == '2023')>2023</option>
                <option value="2024" @selected(old('godina') == '2024')>2024</option>
                <option value="2025" @selected(old('godina') == '2025')>2025</option>
                <option value="2026" @selected(old('godina') == '2026')>2026</option>
            </select>
        </div>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2">
        <div class="form-group">
            <label for="kvartal"><strong>Kvartal:</strong></label>
            <select name="kvartal_id" class="form-select" id="kvartal">
                @foreach($kvartali as $kvartal)
                    <option @selected(old('kvartal_id') == $kvartal->id) value="{{$kvartal->id}}">{{$kvartal->kvartal}} ({{date('d.m', strtotime($kvartal->od))}} - {{date('d.m', strtotime($kvartal->do))}})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2">
        <div class="form-group">
            <label for="gorivo"><strong>Gorivo:</strong></label>
            <div class="form-check">
                <input class="form-check-input" name="gorivo[]" type="checkbox" id="eurodizel" value="eurodizel">
                <label class="form-check-label" for="eurodizel">
                    EURO DIZEL
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="gorivo[]" type="checkbox" id="tng" value="tng">
                <label class="form-check-label" for="tng">
                    TNG
                </label>
            </div>
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <label for="skener"><strong>Skener:</strong></label>
            <select name="skener_id" class="form-select" id="skener">
                @foreach($users as $user)
                    <option value="{{$user->id}}" @selected(old('skener_id') == $user->id)>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <label for="unosilac"><strong>Unosilac:</strong></label>
            <select name="unosilac_id" class="form-select" id="unosilac">
                @foreach($users as $user)
                    <option value="{{$user->id}}" @selected(old('unosilac_id') == $user->id)>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row mb-3 p-3">
    <div class="col-xs-12 col-sm-12 col-md-2 offset-md-10 align-self-end">
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Unesi</button>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection