@extends('layouts.app')

@section('content')

<table class="table table-bordered">
  <tr>
    <th>Firma</th>
     <th>Godina</th>
     <th>Kvartal</th>
     <th>Opis posla</th>
     <th width="280px">&nbsp;</th>
  </tr>
    @foreach ($nalozi as $nalog)
    <tr>
        <td>{{ $nalog->klijent['naziv'] }}</td>
        <td>{{ $nalog->kvartal['godina'] }}</td>
        <td>{{ $nalog->kvartal['kvartal'] }}</td>
        <td>
            @if(Auth::User()->id == $nalog->skener_ulazne_fakture_id
        && ($nalog->sken_ulazne_fakture == 0 || $nalog->sken_izlazne_fakture == 0 || $nalog->sken_izvodi == 0 || $nalog->sken_kompenzacije == 0 || $nalog->sken_knjizna_odobrenja == 0)) Skeniranje, 
        @endif 
        @if(Auth::User()->id == $nalog->unosilac_id  && $nalog->unos_gotov == 0) Unošenje u tabelu @endif</td>
        <td>   
            @if(Auth::User()->id == $nalog->skener_ulazne_fakture_id
        && ($nalog->sken_ulazne_fakture == 0 || $nalog->sken_izlazne_fakture == 0 || $nalog->sken_izvodi == 0 || $nalog->sken_kompenzacije == 0 || $nalog->sken_knjizna_odobrenja == 0))
                <a class="btn btn-primary" href="{{ route('radnalista.selectScan',['id'=>$nalog->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Skeniranje"><i class="fa-solid fa-print"></i></a>
            @endif
            @if(Auth::User()->id == $nalog->unosilac_id && $nalog->unos_gotov == 0)
                <a class="btn btn-primary" href="{{ route('radnalista.tabela',$nalog->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Unošenje"><i class="fa-solid fa-table-list"></i></a>
            @endif
        </td>
    </tr>
    @endforeach
</table>
@endsection