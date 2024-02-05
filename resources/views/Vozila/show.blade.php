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
            <h2>Vozni park od Klijenta: <b>{{ $klijent->naziv }}</b></h2>
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
    {!! Form::open(['method' => 'POST','route' => ['vozila.addVozilo', $klijent->id],'style'=>'display:inline']) !!}
    <div class="row">
        <div class="col-md-3">
            <label for="reg_broj">Novi registarski broj</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="reg_broj" name="reg_broj1" placeholder="LO" value="{{old('reg_broj1')}}">
                <span class="input-group-text">-</span>
                <input type="text" class="form-control" name="reg_broj2" placeholder="1234" value="{{old('reg_broj2')}}">
                <span class="input-group-text">-</span>
                <input type="text" class="form-control" name="reg_broj3" placeholder="XX" value="{{old('reg_broj3')}}">
            </div>
              
        </div>
        <div class="col-md-2">
            <div class="d-grid">
                <label>&nbsp;</label>
                <button class="btn btn-success" type="submit">Unesi</button>
            </div>
        </div>
        <div class="col-md-1">
            <label>Godina</label>
            <select class="form-select godina">
                @if(!$filter)
                <option value="">Izaberi</option> 
                @endif
                @foreach ($kvartali as $kvartal)
                    <option value="{{$kvartal->godina}}">{{$kvartal->godina}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label>Kvartal</label>
            <select class="form-select kvartali">
                @if($filter)
                    @foreach ($kvartali as $kvartal)
                        <option value="{{$kvartal->id}}" @if($kvartal->id == $kvartalId)selected @endif>{{$kvartal->kvartal}} | {{Str::cleanDate($kvartal->od)}} - {{Str::cleanDate($kvartal->do)}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-2">
            <div class="d-grid">
                <label>&nbsp;</label>
                <a href="{{route('vozila.show', ['vozila' => $klijent->id])}}" class="btn btn-danger">Izbriši filter</a>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @if($vozila->isEmpty())
        <div class="alert alert-warning text-center">Klijent nema vozila</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>L</th>
                    <th>S</th>
                    <th>Registarski broj</th>
                    <th>Licenca<br>Od</th>
                    <th>Licenca<br>Do</th>
                    <th class="text-end">Licenca</th>
                    <th>Saobraćajna<br>Od</th>
                    <th>Saobraćajna<br>Do</th>
                    <th>Broj Šasije</th>                    
                    <th>Saobraćajna</th>
                    <th class="text-end">Opcije Vozila</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vozila as $vozilo)
                <tr>
<<<<<<< HEAD
                    <td>@if($vozilo->do >= date('Y-m-d')) <i class="fa-regular fa-circle-check text-success"></i> @else @if($vozilo->od != NULL) <i class="fa-solid fa-triangle-exclamation text-warning"></i> @else <i class="fa-regular fa-circle-xmark text-danger"></i>  @endif @endif </td>
                    <td>@if($vozilo->saobracajna_do >= date('Y-m-d')) <i class="fa-regular fa-circle-check text-success"></i> @else @if($vozilo->saobracajna_od != NULL) <i class="fa-solid fa-triangle-exclamation text-warning"></i> @else <i class="fa-regular fa-circle-xmark text-danger"></i>  @endif @endif </td>
                    <td>{{$vozilo->reg_broj}}</td>
=======
                    <td>
                        @if($vozilo->od > date('Y-m-d'))
                            <i class="fa-solid fa-hand-point-right text-info"></i>
                        @else
                            @if($vozilo->do >= date('Y-m-d')) 
                                <i class="fa-regular fa-circle-check text-success"></i> 
                            @else 
                                @if($vozilo->od != NULL) 
                                    <i class="fa-solid fa-triangle-exclamation text-warning"></i> 
                                @else 
                                    <i class="fa-regular fa-circle-xmark text-danger"></i>  
                                @endif 
                            @endif 
                        @endif
                        {{$vozilo->reg_broj}}</td>
>>>>>>> 74dbb94bebb7de8f7cf36aabd037bf6e5f87eec9
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
                    <td>@if($vozilo->saobracajna_od != NULL) {{Str::cleanDate($vozilo->saobracajna_od)}} @else - @endif</td>
                    <td>@if($vozilo->saobracajna_do != NULL) {{Str::cleanDate($vozilo->saobracajna_do)}} @else - @endif</td>
                    <td>@if($vozilo->broj_sasije != NULL) {{$vozilo->broj_sasije}} @else - @endif</td>                    
                    <td>
                        @if($vozilo->saobracajna != NULL) 
                            <button type="button" class="btn btn-outline-success view-img" src="{{$dokumenta_path.$vozilo->saobracajna}}" data-bs-toggle="tooltip" data-bs-title="Otvori licencu"><i class="fa-solid fa-id-card"></i></button>
                            {!! Form::open(['method' => 'POST','route' => ['vozila.destroySaobracajnu', $klijent->id],'style'=>'display:inline']) !!}
                                <input type="hidden" name="reg_broj" value="{{$vozilo->reg_broj}}">
                                <button class="btn btn-outline-danger show-alert-delete-box" type="submit" data-bs-toggle="tooltip" data-bs-title="Izbriši"><i class="fas fa-trash-alt"></i></button>
                            {!! Form::close() !!}
                        @else 
                            <button type="button" class="btn btn-outline-secondary unos-saobracajne" id="{{$vozilo->id}}" reg="{{$vozilo->reg_broj}}" data-bs-toggle="tooltip" data-bs-title="Uploaduj saobraćajnu"><i class="fa-solid fa-upload"></i></button>
                        @endif
                    </td>
                    <td class="text-end">
                        {!! Form::open(['method' => 'POST','route' => ['vozila.destroyVozilo'],'style'=>'display:inline']) !!}
                                <input type="hidden" name="klijent_id" value="{{$klijent->id}}">
                                <input type="hidden" name="vozilo" value="{{$vozilo->id}}">
                                <button class="btn btn-outline-danger show-alert-delete-box" type="submit" data-bs-toggle="tooltip" data-bs-title="Izbriši vozilo"><i class="fas fa-trash-alt"></i></button>
                        {!! Form::close() !!}
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
            {!! Form::open(['method' => 'POST','route' => ['vozila.upload', $klijent->id],'style'=>'display:inline','id' =>'uploadFormLicenca', 'files'=>'true']) !!}
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
                        <input class="form-control" type="date" name="od" id="od" required>
                    </div>
                    <div class="col-md-2">
                        <label for="do">Do</label>
                        <input class="form-control" type="date" name="do" id="do" required>
                    </div>
                    <div class="col-md-4">
                        <label>Upload</label>
                        <div class="d-grid gap-2">
                            <input type="file" name="upload" id="upload" class="upload_postojeci" required hidden/>
                            <label for="upload" class="btn btn-secondary mt-1 " data-bs-toggle="tooltip" data-bs-title="Uploaduj licencu"><i class="fa-solid fa-upload"></i></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success preSubmitLicencu">Unesi</button>
                <button type="submit" class="submitLicencu" hidden></button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal saobracajna-modal fade" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            {!! Form::open(['method' => 'POST','route' => ['vozila.uploadSaobracajna', $klijent->id],'style'=>'display:inline','files'=>'true']) !!}
            <div class="modal-header">
                <h5 class="modal-title">Unos saobraćajne</h5>
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
                        <label for="saobracajna_od">Od</label>
                        <input class="form-control" type="date" name="saobracajna_od" id="saobracajna_od" required> 
                    </div>
                    <div class="col-md-2">
                        <label for="saobracajna_do">Do</label>
                        <input class="form-control" type="date" name="saobracajna_do" id="saobracajna_do" required>
                    </div>
                    <div class="col-md-4">
                        <label for="broj_sasije">Broj Šasije</label>
                        <input class="form-control" type="text" name="broj_sasije" id="broj_sasije" required>
                    </div>
                    <div class="col-md-4">
                        <label>Upload</label>
                        <div class="d-grid gap-2">
                            <input type="file" name="upload_saobracanje" id="upload_saobracanje" class="upload_postojeci" required hidden/>
                            <label for="upload_saobracanje" class="btn btn-secondary mt-1 " data-bs-toggle="tooltip" data-bs-title="Uploaduj saobraćajnu"><i class="fa-solid fa-upload"></i></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success preSubmitSaobracajnu">Unesi</button>
                <button type="submit" class="submitSaobracajnu" hidden></button>
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
@endsection
@section('pagescript')
<script type="text/javascript">
    $('.kvartali').change(function() {
        let kvartal = $(this).val();
        console.log(kvartal);
        var showRoute = "{{route('vozila.show', ['vozila' => $klijent->id])}}"+'/'+kvartal;
        window.location = showRoute;
    });
    $('.godina').change(function() {
        let godina = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });
        var request = $.ajax({
            url: '{{route("vozila.getKvartal")}}',
            method: 'POST',
            data: {godina: godina},
            dataType: 'json',
            success: function(result){
                let kvartali = result.kvartali;
                let out = '<option value="">Izaberi</option>';
                $(kvartali).each(function() {
                    out += '<option value="'+$(this)[0].id+'">'+$(this)[0].kvartal+'</option>';
                });
                $('.kvartali').html(out);
            }
        });
    });
    $('input[name="upload"]').change(function() {
        var fileName = $(this)[0].files[0].name;
        $('label[for="upload"]').html(fileName);
        $('label[for="upload"]').removeClass('btn-secondary');
        $('label[for="upload"]').removeClass('btn-danger');
        $('label[for="upload"]').removeClass('border-danger');
        $('label[for="upload"]').removeClass('border-2');
        $('label[for="upload"]').removeClass('fw-bold');
        $('label[for="upload"]').addClass('btn-success');
    });
    $('.preSubmitLicencu').click(function() {
        if($('input[name="upload"]').val() != '') {
            $('.submitLicencu').click();
        } else {
            $('label[for="upload"]').addClass('border-danger border-2 fw-bold');
            $('label[for="upload"]').html('Izaberi Fajl');
        }
    });

    $('input[name="upload_saobracanje"]').change(function() {
        var fileName = $(this)[0].files[0].name;
        $('label[for="upload_saobracanje"]').html(fileName);
        $('label[for="upload_saobracanje"]').removeClass('btn-secondary');
        $('label[for="upload_saobracanje"]').removeClass('btn-danger');
        $('label[for="upload_saobracanje"]').removeClass('border-danger');
        $('label[for="upload_saobracanje"]').removeClass('border-2');
        $('label[for="upload_saobracanje"]').removeClass('fw-bold');
        $('label[for="upload_saobracanje"]').addClass('btn-success');
    });
    $('.preSubmitSaobracajnu').click(function() {
        if($('input[name="upload_saobracanje"]').val() != '') {
            $('.submitSaobracajnu').click();
        } else {
            $('label[for="upload_saobracanje"]').addClass('border-danger border-2 fw-bold');
            $('label[for="upload_saobracanje"]').html('Izaberi Fajl');
        }
    });
    $('.unos-licence').click(function() {
        let reg_id = $(this).attr('id');
        let reg_br = $(this).attr('reg');
        $('[name="reg_broj"]').val(reg_br);
        $('.licenca-modal').modal('show');
    });

    $('.unos-saobracajne').click(function() {
        let reg_id = $(this).attr('id');
        let reg_br = $(this).attr('reg');
        $('[name="reg_broj"]').val(reg_br);
        $('.saobracajna-modal').modal('show');
    });

    $('body').on('click', '.view-img', function() {
        var pdf = $(this).attr('src');
        $('.pdf-frame').attr('src', pdf);
        $('#pdf-modal').modal('show');
    });
</script>
@stop
