@extends('layouts.app')

@section('content')
<div class="row justify-content-between mb-5">
    <div class="col-md-3">
        <h2>Kreiraj novi nalog</h2>
    </div>
    <div class="col-md-2 text-end">
        <a class="btn btn-outline-secondary" href="{{ route('nalozi.index') }}"> Nazad</a>
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

{!! Form::model($nalozi, ['method' => 'PATCH','route' => ['nalozi.update', $nalozi->id]]) !!}
<input type="hidden" name="klijent_id" value="{{$nalozi->klijent_id}}">
<div class="row mb-3 p-3 shadow">
    <div class="col-xs-2 col-sm-2 col-md-2">
        <div class="form-group">
            <label for="godina"><strong>Godina:</strong></label>
            <select name="godina" class="form-select" id="godina">
                <option value="2018" @if($nalozi->kvartal['godina'] == '2018') selected @endif>2018</option>
                <option value="2019" @if($nalozi->kvartal['godina'] == '2019') selected @endif>2019</option>
                <option value="2020" @if($nalozi->kvartal['godina'] == '2020') selected @endif>2020</option>
                <option value="2021" @if($nalozi->kvartal['godina'] == '2021') selected @endif>2021</option>
                <option value="2022" @if($nalozi->kvartal['godina'] == '2022') selected @endif>2022</option>
                <option value="2023" @if($nalozi->kvartal['godina'] == '2023') selected @endif>2023</option>
                <option value="2024" @if($nalozi->kvartal['godina'] == '2024') selected @endif>2024</option>
                <option value="2025" @if($nalozi->kvartal['godina'] == '2025') selected @endif>2025</option>
                <option value="2026" @if($nalozi->kvartal['godina'] == '2026') selected @endif>2026</option>
            </select>
        </div>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2">
        <div class="form-group">
            <label for="kvartal"><strong>Kvartal:</strong></label>
            <select name="kvartal_id" class="form-select" id="kvartal">
                @foreach($kvartali as $kvartal)
                    <option value="{{$kvartal->id}}" @if($nalozi->kvartal['id'] == $kvartal->id) selected @endif>{{$kvartal->kvartal}} ({{date('d.m', strtotime($kvartal->od))}} - {{date('d.m', strtotime($kvartal->do))}})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2">
        <div class="form-group">
            <label for="gorivo"><strong>Gorivo:</strong></label>
            <div class="form-check">
                <input class="form-check-input" name="gorivo[]" type="checkbox" id="eurodizel" value="eurodizel" @if($nalozi->eurodizel == 1) checked @endif></select>
                <label class="form-check-label" for="eurodizel">
                    EURO DIZEL
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="gorivo[]" type="checkbox" id="tng" value="tng" @if($nalozi->tng == 1) checked @endif>
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
                    <option value="{{$user->id}}"  @if($nalozi->skener['id'] == $user->id) selected @endif>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <label for="unosilac"><strong>Unosilac:</strong></label>
            <select name="unosilac_id" class="form-select" id="unosilac">
                @foreach($users as $user)
                    <option value="{{$user->id}}" @if($nalozi->unosilac['id'] == $user->id) selected @endif>{{$user->name}}</option>
                @endforeach
            </select>
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