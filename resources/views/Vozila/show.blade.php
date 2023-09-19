@extends('layouts.app')
@section('pagestyle')
    <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('assets/plugins/dropzone/dropzone.min.css')}}" type="text/css" />
    <style>
        label {
            font-weight: bold;
        }
        .prw_img {
            width:100%;
            margin:0 auto;
        }
        .prv-img {
            width:100%;
            height:100%;
            background-repeat: no-repeat;
            background-size: contain;
        }
        .full-img {
            width:100%;
        }
        </style>
@stop


@section('content')
<div class="container">
    <div class="row justify-content-between mb-5">
        <div class="col-md-10">
            <h2>Licenca od Klijenta: <b>{{ $klijent->naziv }}</b></h2>
        </div>
        <div class="col-md-2 text-end">
            <a class="btn btn-outline-secondary" href="{{ route('dokumenta.show', $klijent->id) }}">Nazad</a>
        </div>
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    @if($vozila->isEmpty())
        <div class="alert alert-warning text-center">Klijent nema vozila</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Registarski broj</th>
                    <th>Od</th>
                    <th>Do</th>
                    <th class="text-end">Licenca</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vozila as $vozilo)
                <tr>
                    <td>@if($vozilo->do >= date('Y-m-d')) <i class="fa-regular fa-circle-check text-success"></i> @else @if($vozilo->od != NULL) <i class="fa-solid fa-triangle-exclamation text-warning"></i> @else <i class="fa-regular fa-circle-xmark text-danger"></i>  @endif @endif {{$vozilo->reg_broj}}</td>
                    <td>@if($vozilo->od != NULL) {{Str::cleanDate($vozilo->od)}} @else - @endif</td>
                    <td>@if($vozilo->do != NULL) {{Str::cleanDate($vozilo->do)}} @else - @endif</td>
                    <td class="text-end">
                        @if($vozilo->licenca != NULL) 
                            <button type="button" class="btn btn-outline-success view-img" src="{{$dokumenta_path.$vozilo->licenca}}" data-bs-toggle="tooltip" data-bs-title="Otvori licencu"><i class="fa-solid fa-id-card"></i></button>
                            {!! Form::open(['method' => 'DELETE','route' => ['vozila.destroy', $klijent->id],'style'=>'display:inline']) !!}
                                <input type="hidden" name="reg_broj" value="{{$vozilo->reg_broj}}">
                                <button class="btn btn-outline-danger show-alert-delete-box" type="submit" data-bs-toggle="tooltip" data-bs-title="Izbriši"><i class="fas fa-trash-alt"></i></button>
                            {!! Form::close() !!}
                        @else 
                            <button type="button" class="btn btn-outline-secondary unos-licence" id="{{$vozilo->id}}" reg="{{$vozilo->reg_broj}}" data-bs-toggle="tooltip" data-bs-title="Uploaduj licencu"><i class="fa-solid fa-upload"></i></button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
<div class="modal licenca-modal fade" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            {!! Form::open(['method' => 'POST','route' => ['vozila.upload', $klijent->id],'style'=>'display:inline','files'=>'true']) !!}
            <div class="modal-header">
                <h5 class="modal-title">Unos Licence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="docType" value="licenca">
                <div class="row">
                    <div class="col-md-4">
                        <label for="reg_broj">Registarski broj</label>
                        <input class="form-control" type="text" name="reg_broj" id="reg_broj" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="od">Od</label>
                        <input class="form-control" type="date" name="od" id="od">
                    </div>
                    <div class="col-md-2">
                        <label for="do">Do</label>
                        <input class="form-control" type="date" name="do" id="do">
                    </div>
                    <div class="col-md-4">
                        <label>Upload</label>
                        <div class="d-grid gap-2">
                            <input type="file" name="upload" id="upload" class="upload_postojeci" hidden/>
                            <label for="upload" class="btn btn-secondary mt-1 " data-bs-toggle="tooltip" data-bs-title="Uploaduj licencu"><i class="fa-solid fa-upload"></i></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Unesi</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal imgLightBox" tabindex="-1">
    <div class="modal-dialog" style="height: calc(100vh - 100px);">
    <div class="modal-content" style="height:100%;">
        <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="prv-img">
            </div>
        </div>
    </div>
    </div>
</div>

@endsection
@section('pagescript')
<script type="text/javascript">
    $('.unos-licence').click(function() {
        let reg_id = $(this).attr('id');
        let reg_br = $(this).attr('reg');
        $('[name="reg_broj"]').val(reg_br);
        $('.licenca-modal').modal('show');
    });

    $('body').on('click', '.view-img', function() {
        var img = $(this).attr('src');
        $('.prv-img').css('background-image', 'url('+img+')');
        
        $('.imgLightBox').modal('show');
    });
</script>
@stop
