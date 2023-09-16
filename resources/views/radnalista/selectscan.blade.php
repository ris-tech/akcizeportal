@extends('layouts.app')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h1>Skeniranje</h1>
    </div>
</div>
    <div class="row">
        @if(Auth::User()->id == $nalozi->skener_ulazne_fakture_id && $nalozi->sken_ulazne_fakture == 0)
            <div class="col-md-3 text-center fs-4 mb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('radnalista.scan',['id' => $nalozi->id, 'tip' => 'sken_ulazne_fakture', 'tip_ime' => 'Ulazne fakture']) }}" class="btn btn-secondary p-5 fs-5">Ulazne fakture</a> 
                </div>
            </div>
        @endif
        @if(Auth::User()->id == $nalozi->skener_izlazne_fakture_id && $nalozi->sken_izlazne_fakture == 0)
            <div class="col-md-3 text-center fs-4 mb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('radnalista.scan',['id' => $nalozi->id, 'tip' => 'sken_izlazne_fakture', 'tip_ime' => 'Izlazne fakture']) }}" class="btn btn-secondary p-5 fs-5">Izlazne fakture</a> 
                </div>
            </div>
        @endif
        @if(Auth::User()->id == $nalozi->skener_izvodi_id && $nalozi->sken_izvodi == 0)
            <div class="col-md-3 text-center fs-4 mb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('radnalista.scan',['id' => $nalozi->id, 'tip' => 'sken_izvodi', 'tip_ime' => 'Izvodi']) }}" class="btn btn-secondary p-5 fs-5">Izvodi</a> 
                </div>
            </div>
        @endif
        @if(Auth::User()->id == $nalozi->skener_analiticke_kartice_id && $nalozi->sken_analiticke_kartice == 0)
            <div class="col-md-3 text-center fs-4 mb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('radnalista.scan',['id' => $nalozi->id, 'tip' => 'sken_analiticke_kartice', 'tip_ime' => 'Analitičke kartice']) }}" class="btn btn-secondary p-5 fs-5">Analitičke kartice</a> 
                </div>
            </div>
        @endif
        @if(Auth::User()->id == $nalozi->skener_licenca_id && $nalozi->sken_licenca == 0)
            <div class="col-md-3 text-center fs-4 mb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('radnalista.scan',['id' => $nalozi->id, 'tip' => 'sken_licenca', 'tip_ime' => 'Licenca']) }}" class="btn btn-secondary p-5 fs-5">Licenca</a> 
                </div>
            </div>
        @endif
        @if(Auth::User()->id == $nalozi->skener_saobracajna_id && $nalozi->sken_saobracajna == 0)
            <div class="col-md-3 text-center fs-4 mb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('radnalista.scan',['id' => $nalozi->id, 'tip' => 'sken_saobracajna', 'tip_ime' => 'Saobračajna']) }}" class="btn btn-secondary p-5 fs-5">Saobračajna</a> 
                </div>
            </div>
        @endif
        @if(Auth::User()->id == $nalozi->skener_depo_karton_id && $nalozi->sken_depo_karton == 0)
            <div class="col-md-3 text-center fs-4 mb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('radnalista.scan',['id' => $nalozi->id, 'tip' => 'sken_depo_karton', 'tip_ime' => 'Depo karton']) }}" class="btn btn-secondary p-5 fs-5">Depo karton</a> 
                </div>
            </div>
        @endif
        @if(Auth::User()->id == $nalozi->skener_kompenzacije_id && $nalozi->sken_kompenzacije == 0)
            <div class="col-md-3 text-center fs-4 mb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('radnalista.scan',['id' => $nalozi->id, 'tip' => 'sken_kompenzacije', 'tip_ime' => 'Kompenzacije']) }}" class="btn btn-secondary p-5 fs-5">Kompenzacije</a> 
                </div>
            </div>
        @endif
        @if(Auth::User()->id == $nalozi->skener_knjizna_odobrenja_id && $nalozi->sken_knjizna_odobrenja == 0)
            <div class="col-md-3 text-center fs-4 mb-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('radnalista.scan',['id' => $nalozi->id, 'tip' => 'sken_knjizna_odobrenja', 'tip_ime' => 'Knjižna odobrenja']) }}" class="btn btn-secondary p-5 fs-5">Knjižna odobrenja</a> 
                </div>
            </div>
        @endif

    </div>
@endsection