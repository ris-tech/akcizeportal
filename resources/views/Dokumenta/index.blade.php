@extends('layouts.app')



@section('content')
<div class="container">
    <div class="row justify-content-between mb-5">
        <div class="col-md-10">
            <h2>Dokumenti Klijenta: <b>{{ $klijent->naziv }}</b></h2>
        </div>
        <div class="col-md-2 text-end">
            <a class="btn btn-outline-secondary" href="{{ route('klijenti.index') }}">Nazad</a>
        </div>
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row border-bottom">
        <div class="col-md-2">
            <b>Ugovor </b><br>
            @if($ugovor != '-') <i class="fa-regular fa-circle-check text-success"></i> @else <i class="fa-regular fa-circle-xmark text-danger"></i> @endif
        </div>
        <div class="col-md-2">
            <b>Br. Ugovora</b><br>
            {{ $broj_ugovora }}
        </div>
        <div class="col-md-2">
            <b>Datum ugovora</b><br>
            @if ($datum_ugovora == '-') {{ $datum_ugovora }} @else {{ date('d.m.Y', strtotime($datum_ugovora)) }} @endif
        </div>
        <div class="col-md-6 text-end">
            @if($ugovor != '-')
                <button data-bs-toggle="tooltip" data-bs-title="Otvori ugovor" class="btn btn-outline-secondary open-pdf-viewer mt-1" data-src="{{ env('APP_URL') }}/{{ $dokumenta_path }}/{{ $ugovor }}"><i class="fa-solid fa-file-signature"></i></button>
                {!! Form::open(['method' => 'DELETE','route' => ['dokumenta.destroy', $klijent->id],'style'=>'display:inline']) !!}
                    <input type="hidden" name="docType" value="ugovor">
                    <button class="btn btn-outline-danger show-alert-delete-box" type="submit" data-bs-toggle="tooltip" data-bs-title="Izbriši"><i class="fas fa-trash-alt"></i></button>
                {!! Form::close() !!}
                {!! Form::open(['method' => 'POST','route' => ['dokumenta.sendMail', ['id' => $klijent->id]], 'class'=>'ugovor-form','style'=>'display:inline']) !!}
                    <input type="hidden" name="docType" value="ugovor">
                    <input type="hidden" name="docTypeName" value="Ugovor">
                    <input type="hidden" name="email" class="emailVal" value="@if ($odgovorno_lice->email != NULL) {{ $odgovorno_lice->email }} @endif">
                    <button docType="ugovor" class="btn btn-outline-primary @if ($odgovorno_lice->email == NULL) show-mail-box @else ask-send @endif" type="submit" data-bs-toggle="tooltip" data-bs-title="Pošalji Mail"><i class="fa-solid fa-envelope"></i></button>
                {!! Form::close() !!}


            @else
                <a data-bs-toggle="tooltip" data-bs-title="Kreiraj ugovor" class="btn btn-outline-warning mt-1" href="{{ route('ugovor.edit',$klijent->id) }}" target="_self"><i class="fa-solid fa-file-signature"></i></a>
            @endif
        </div>
    </div>
    <div class="row border-bottom">
        <div class="col-md-2">
            <b>PEP-Obrazac</b><br>
            @if($pep != 'Nema') <i class="fa-regular fa-circle-check text-success"></i> @else <i class="fa-regular fa-circle-xmark text-danger"></i> @endif
        </div>
        <div class="col-md-4">
            <b>Datum potpisa</b><br>
            @if ($datum_pep == '-') {{ $datum_pep }} @else {{ date('d.m.Y', strtotime($datum_pep)) }} @endif
        </div>
        <div class="col-md-6 text-end">
            @if($pep != 'Nema')
                <button data-bs-toggle="tooltip" data-bs-title="Otvori PEP-Obrazac" class="btn btn-outline-secondary open-pdf-viewer mt-1" data-src="{{ env('APP_URL') }}/{{ $dokumenta_path }}/{{ $pep }}"><i class="fa-solid fa-file-signature"></i></button>
                {!! Form::open(['method' => 'DELETE','route' => ['dokumenta.destroy', $klijent->id],'style'=>'display:inline']) !!}
                    <input type="hidden" name="docType" value="pep">
                    <button class="btn btn-outline-danger show-alert-delete-box" type="submit" data-bs-toggle="tooltip" data-bs-title="Izbriši"><i class="fas fa-trash-alt"></i></button>
                {!! Form::close() !!}
                {!! Form::open(['method' => 'POST','route' => ['dokumenta.sendMail', ['id' => $klijent->id]], 'class'=>'pep-form', 'style'=>'display:inline']) !!}
                    <input type="hidden" name="docType" value="pep">
                    <input type="hidden" name="docTypeName" value="PEP Obrazac">
                    <input type="hidden" name="email" class="emailVal" value="">
                    <button class="btn btn-outline-primary show-mail-box" docType="pep" type="submit" data-bs-toggle="tooltip" data-bs-title="Pošalji Mail"><i class="fa-solid fa-envelope"></i></button>
                {!! Form::close() !!}
            @else
                <a data-bs-toggle="tooltip" data-bs-title="Kreiraj PEP-Obrazac" href="{{ route('pep.edit',$klijent->id) }}" class="btn btn-outline-warning mt-1" target="_self"><i class="fa-solid fa-file-signature"></i></a>
            @endif
        </div>
    </div>
</div>
<div class="modal fade pdf-modal" id="pdf-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="max-height:100%;">
        <div class="modal-content" style="min-height:calc(100vh - 100px)">
        <div class="modal-body text-center">
            <iframe src="" class="pdf-frame" style="width:100%;height:100%;"></iframe>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
        </div>
        </div>
    </div>
</div>
<div class="modal fade email-modal" id="mail-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
        <div class="modal-body text-center">
            <label for="email">E-Mail</label>
            <input type="email" class="form-control email" id="email" placeholder="E-Mail">
            <input type="hidden" class="modalDocType" value="">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success send-mail">Pošalji</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
        </div>
        </div>
    </div>
</div>
@endsection
@section('pagescript')
<script>
     $('body').on('click', '.open-pdf-viewer', function(){
        var pdf = $(this).attr('data-src');
        $('.pdf-frame').attr('src', pdf);
        $('#pdf-modal').modal('show');
     });
     $("#pdf-modal").on("hidden.bs.modal", function () {
        $('.pdf-frame').attr('src', '');
    });
</script>
@stop

