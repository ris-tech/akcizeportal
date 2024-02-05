@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10">
        <h1>Izveštaji po vozilu</h1>
    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table table-stripped">
            <thead>
            <tr>
                <th>Klijent</th>
                <th>Kvartal</th>
                <th class="text-end">Opcije</th>
            </tr>
            </thead>
            <tbody>
                @foreach($nalozi as $nalog)
                    <tr>
                        <td>{{ $nalog->klijent->naziv }}</td>
                        <td>{{ $nalog->kvartal->godina }} - {{ $nalog->kvartal->kvartal }}</td>
                        <td class="text-end"><a href="{{route('izvestajOPlacanju.edit',$nalog->id)}}" type="button" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-title="Otvori Izveštaj o plaćanju"><i class="fa-solid fa-pen-to-square"></i></a></td>                  
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection