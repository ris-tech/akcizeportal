@extends('layouts.app')

@section('content')
<div class="row justify-content-between">
    <div class="col-lg-3">
            <h2>Novi nalog</h2>
    </div>
    <div class="col-lg-2 text-end">
        <a class="btn btn-outline-secondary" href="{{ route('nalozi.show',$id) }}"> Nazad</a>
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
<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
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
                <option value="2023" selected @selected(old('godina') == '2023')>2023</option>
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
                <input class="form-check-input" name="gorivo[]" type="checkbox" id="evrodizel" value="evrodizel">
                <label class="form-check-label" for="evrodizel">
                    EVRO DIZEL
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="gorivo[]" type="checkbox" id="tng" value="tng">
                <label class="form-check-label" for="tng">
                    TNG
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="taxi"><strong>Izgled tabele:</strong></label>
            <div class="form-check">
                <input class="form-check-input" name="taxi" type="checkbox" id="taxi" value="1">
                <label class="form-check-label" for="evrodizel">
                    Taxi
                </label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <label for="skener_ulazne_fakture_id"><strong>Ulazne fakture:</strong></label>
            <select name="skener_ulazne_fakture_id" class="form-select" id="skener_ulazne_fakture_id" required>
                <option value="" disabled selected>Izaberi</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}"  @selected(old('skener_ulazne_fakture_id') == $user->id)>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="skener_izlazne_fakture_id"><strong>Izlazne fakture:</strong></label>
            <select name="skener_izlazne_fakture_id" class="form-select" id="skener_izlazne_fakture_id" required>
                <option value="" disabled selected>Izaberi</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}"  @selected(old('skener_izlazne_fakture_id') == $user->id)>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="skener_izvodi_id"><strong>Izvodi:</strong></label>
            <select name="skener_izvodi_id" class="form-select" id="skener_izvodi_id" required>
                <option value="" disabled selected>Izaberi</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}"  @selected(old('skener_izvodi_id') == $user->id)>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="skener_kompenzacije_id"><strong>Kompenzacije:</strong></label>
            <select name="skener_kompenzacije_id" class="form-select" id="skener_kompenzacije_id">
                <option value="" disabled selected>Izaberi</option>
				<option value="">Nema</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}"  @selected(old('skener_kompenzacije_id') == $user->id)>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="skener_knjizna_odobrenja_id"><strong>Knjizna odobrenja:</strong></label>
            <select name="skener_knjizna_odobrenja_id" class="form-select" id="skener_knjizna_odobrenja_id">
                <option disabled selected>Izaberi</option>
                <option value="">Nema</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}"  @selected(old('skener_knjizna_odobrenja_id') == $user->id)>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <div class="form-group">
            <label for="unosilac_id"><strong>Unosilac:</strong></label>
            <select name="unosilac_id" class="form-select" id="unosilac_id" required>
                <option disabled selected>Izaberi</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}" @selected(old('unosilac_id') == $user->id)>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
		<label for="preuzeto">Preuzeta dokumentacija</label>
		<input type="date" class="form-control" name="dokumentacija_in" id="preuzeto" value="{{old('dokumentacija_in')}}">
        <label for="vracenja">Komentar za preuzetu dokumentacijau</label>
		<textarea class="form-control" name="dokumentacija_in_komentar">{{old('dokumentacija_in_komentar')}}</textarea>
		<label for="vracenja">Vraćenja dokumentacija</label>
		<input type="date" class="form-control" id="vracenja" name="dokumentacija_out" value="{{old('dokumentacija_out')}}">
        <label for="vracenja">Komentar za vraćenu dokumentacijau</label>
		<textarea class="form-control" name="dokumentacija_out_komentar">{{old('dokumentacija_out_komentar')}}</textarea>
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
@section('pagescript')
<script>
     $('[name="godina"]').change(function() {
        var godina = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="csrf-token"]').val()
            }
        });
        var request = $.ajax({
            url: '{{route("nalozi.getKvartali")}}',
            method: 'POST',
            data: {godina: godina},
            dataType: 'json',
            success: function(result){
                var res_len = result.length;
                var output = '';
                if (res_len > 0) {
                    for (let i = 0; i < res_len; i++) {
                        var crrod = new Date(result[i].od);
                        var crrdo = new Date(result[i].do);
                        var newod = String(crrod.getDate()).padStart(2, '0')+'.'+String(crrod.getMonth() + 1).padStart(2, '0');
                        var newdo = String(crrdo.getDate()).padStart(2, '0')+'.'+String(crrdo.getMonth() + 1).padStart(2, '0');
                        output += '<option value="'+result[i].id+'">'+result[i].kvartal+' ('+newod+' - '+newdo+')</option>';
                    }
                } else {
                    output = '<option value="" selected disabled>! Nema Kvartala !</option>';
                }
                $('[name="kvartal_id"]').html(output);

            }
        });
     });
</script>
@stop
