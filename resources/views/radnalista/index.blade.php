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
        <td>@if(Auth::User()->name == $nalog->skener['name'] && $nalog->sken_gotov == 0) Skeniranje @endif @if(Auth::User()->name == $nalog->unosilac['name']  && $nalog->unos_gotov == 0) Unošenje u tabelu @endif</td>
        <td>   
            @if(Auth::User()->name == $nalog->skener['name'] && $nalog->sken_gotov == 0)
                <a class="btn btn-primary" href="{{ route('radnalista.scan',['id'=>$nalog->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Skeniranje"><i class="fa-solid fa-print"></i></a>
            @endif
            @if(Auth::User()->name == $nalog->unosilac['name'] && $nalog->unos_gotov == 0)
                <a class="btn btn-primary" href="{{ route('radnalista.tabela',$nalog->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Unošenje"><i class="fa-solid fa-table-list"></i></a>
            @endif
        </td>
    </tr>
    @endforeach
</table>
@endsection