@extends('layouts.app-wide')

@section('pagestyle')
    <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('assets/plugins/dropzone/dropzone.min.css')}}" type="text/css" />
    <style>
.dropzone {border-radius: 3px;
border: 1px solid #aaa;
background: white;
height: 100%;
width: 100%;
max-width: 100%;
margin: auto;
box-shadow: 0 .625rem 1.25rem #0000001a;
}
.dropzone .dz-preview .dz-image {
    border-radius: 2px !important;
    border: 1px solid #aaa;
    overflow: hidden;
    overflow-x: hidden;
    overflow-y: hidden;
    width: 200px !important;
    height: 250px !important;
    position: relative;
    display: block;
    z-index: 10;

}
.prw_img {
    width:100%;
    margin:0 auto;
}
.prv-img {
    width:100%;
    height:100%;
    background-repeat: no-repeat;
    background-size: cover;
}
.dz-options {
    margin-top: 1em;
}
.full-img {
    width:100%;
}
.img-preview-cont {
    position: absolute;
    background-color: rgba(0, 0, 0, 0.5);
    width:100%;
    height:80%;
}
        </style>
@stop

@section('content')
@if(!$resp)
    <h1>Unošenje</h1>
    <div class="row">
        <div class="col-md-12 alert alert-warning text-center fw-bold">
            Nalog nepostojeći!
        </div>
    </div>  
@else
    @if($nalozi->unosilac_id != Auth::user()->id)
        <h1>Unošenje</h1>
        <div class="row">
            <div class="col-md-12 alert alert-warning text-center fw-bold">
                Niste zadeljeni tom nalogu za unošenje!
            </div>
        </div>
    @else
        @if($nalozi->unos_gotov == 1)
            <h1>Unošenje</h1>
            <div class="row">
                <div class="col-md-12 alert alert-warning text-center fw-bold">
                    Unos za taj nalog je završen!
                </div>
            </div>
        @else
            <div class="position-fixed bottom-0 end-0">
                {!! Form::open(array('route' => 'radnalista.finishScan','id' => 'finish-unos-form','method'=>'POST')) !!}
                    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                    <input type="hidden" name="nalog_id" value="{{$nalozi->id}}">
                    <button class="btn btn-outline-success finish-unos" type="submit">Završi unos</button>
                {!! Form::close() !!}
                </div>
            <div class="row">
                <div class="col-md-8">
                    <h1>Unošenje</h1>
                </div>
                <div class="col-md-2">
                    <a href="{{route('radnalista.extImg', $nalozi->id)}}" class="btn btn-outline-success open-ext-img mb-2" type="button" target="_blank">Otvori externo</a>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Sume</button>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-success save-table mb-2">Sačuvaj</a>
                </div>
            </div>
            <div class="row full-height">
                <div class="col-md-8">
                    @include('radnalista.rlhead')
                    {!! Form::open(array('route' => 'radnalista.store','id' => 'save-unos-form','method'=>'POST')) !!}
                    <input type="hidden" name="nalog_id" value="{{$nalozi->id}}">
                    <table class="table mt-3 unos-tabela">
                        <tr>
                            <th width="5%">Br.</th>
                            <th width="10%">Datum</th>
                            <th width="15%">BR. FAKTURE</th>
                            <th width="15%">VRSTA GORIVA</th>
                            <th width="15%">DOBAVLJAČ</th>
                            <th width="12%">IZNOS</th>
                            <th width="10%">Kolicina</th>
                            <th width="18%">REG. VOZILA</th>
                        </tr>
                        @foreach($pozicije as $pozicija)
                        <tr class="line-row cloned">
                            <td><input type="text" readonly="readonly" value="{{$pos++}}" class="form-control" name="br_pos[]"></td>
                            <td><input class="form-control" type="date" name="datum[]" value="{{$pozicija->datum_fakture}}"></td>
                            <td><input class="form-control" type="text" name="br_fakture[]" placeholder="BR. FAKTURE" value="{{$pozicija->broj_fakture}}"></td>
                            <td>@if($nalozi->eurodizel == 1 && $nalozi->tng == 1)
                                <select class="form-select" name="gorivo[]">
                                    <option value="" selected disabled>Izaberi</option>
                                    <option value="EURO DIZEL" @if($pozicija->gorivo == 'EURO DIZEL') selected @endif>EURO DIZEL</option>
                                    <option value="TNG" @if($pozicija->gorivo == 'TNG') selected @endif>TNG</option>
                                </select>
                                @elseif($nalozi->eurodizel)
                                <select class="form-select" name="gorivo[]">
                                    <option value="EURO DIZEL" selected>EURO DIZEL</option>
                                </select>
                                @else
                                <select class="form-select" name="gorivo[]">
                                    <option value="TNG" selected>TNG</option>
                                </select> 
                                @endif
                                </td>
                            <td>
                                <select class="form-select" name="dobavljac[]">
                                    @foreach ($dobavljaci as $dobavljac)
                                    <option value="{{$dobavljac->id}}" @if($pozicija->dobavljac_id == $dobavljac->id) selected @endif>{{$dobavljac->ime}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="iznos[]" class="form-control" placeholder="0,00" value="{{str_replace('.', ',', $pozicija->iznos)}}">
                                    <span class="input-group-text">RSD</span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="kolicina[]" class="form-control" placeholder="0,00" value="{{str_replace('.', ',', $pozicija->kolicina)}}">
                                    <span class="input-group-text">L</span>
                                </div>
                            </td>
                            <td  width="250">
                                <div class="input-group">
                                    <input type="text" name="reg_vozila[]" class="form-control" placeholder="LO-123-XX" value="{{$pozicija->vozila}}">
                                    <button type="button" class="btn btn-success clone-row" data-bs-toggle="tooltip" data-bs-title="Dodaj red"><i class="fa-solid fa-plus"></i></button>
                                    <button type="button" class="btn btn-danger del-row" data-bs-toggle="tooltip" data-bs-title="Izbriši red"><i class="fa-solid fa-minus"></i></button>
                                </div>
                            </td>
                        </tr>        
                        @endforeach
                        <tr class="line-row">
                            <td><input type="text" readonly="readonly" value="{{$pos++}}" class="form-control" name="br_pos[]"></td>
                            <td><input class="form-control" type="date" name="datum[]"></td>
                            <td><input class="form-control" type="text" name="br_fakture[]" placeholder="BR. FAKTURE"></td>
                            <td>@if($nalozi->eurodizel == 1 && $nalozi->tng == 1)
                                <select class="form-select" name="gorivo[]">
                                    <option value="" selected disabled>Izaberi</option>
                                    <option value="EURO DIZEL">EURO DIZEL</option>
                                    <option value="TNG">TNG</option>
                                </select>
                                @elseif($nalozi->eurodizel)
                                <select class="form-select" name="gorivo[]">
                                    <option value="EURO DIZEL" selected>EURO DIZEL</option>
                                </select>
                                @else
                                <select class="form-select" name="gorivo[]">
                                    <option value="TNG" selected>TNG</option>
                                </select> 
                                @endif
                                </td>
                            <td>
                                <select class="form-select" name="dobavljac[]"> 
                                    <option value="" selected disabled>Izaberi</option>
                                    @foreach ($dobavljaci as $dobavljac)
                                    <option value="{{$dobavljac->id}}">{{$dobavljac->ime}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="iznos[]" class="form-control" placeholder="0,00">
                                    <span class="input-group-text">RSD</span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="kolicina[]" class="form-control" placeholder="0,00">
                                    <span class="input-group-text">L</span>
                                </div>
                            </td>
                            <td  width="250">
                                <div class="input-group">
                                    <input type="text" name="reg_vozila[]" class="form-control" placeholder="LO-123-XX">
                                    <button type="button" class="btn btn-success clone-row" data-bs-toggle="tooltip" data-bs-title="Dodaj red"><i class="fa-solid fa-plus"></i></button>
                                    <button type="button" class="btn btn-danger del-row" data-bs-toggle="tooltip" data-bs-title="Izbriši red"><i class="fa-solid fa-minus"></i></button>
                                </div>
                            </td>
                        </tr>
                    </table>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-4 border-start border-3">
                    <div class="full-height" style="overflow-y: auto;overflow-x: hidden;">
                        <div class="img-preview-cont text-center p-3" style="display: none;width:100%;width: -webkit-fill-available;width: -moz-available;width: stretch;">&nbsp;</div>
                        <div class="row">
                            @foreach($fajlovi as $fajl)
                            <div class="col-md-6 mb-2">
                                <img src="{{$dokumenta_path.$fajl->fajl}}" style="width:100%;" class="border border-1 zoom-img">
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasBottomLabel">Sume</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body small">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <th>BR.</th>
                                    <th>REG. VOZILA</th>
                                    <th>UKUPNO LITARA</th>
                                    <th>UKUPNI IZNOS</th>
                                </tr>
                                @foreach($suma as $pos)
                                <tr>
                                    <th>{{$sumpos++}}</th>
                                    <th>{{$pos->vozila}}</th>
                                    <th>{{number_format($pos->kol_goriva, 2, ',', '.')}} L</th>
                                    <th>{{number_format($pos->iznos_goriva, 2, ',', '.')}} RSD</th>
                                </tr>
                                @endforeach
                        </div>
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
            
            @section('pagescript')
            <script type="text/javascript">
                $('.save-table').click(function() {
                    var cnt_tr = $('body').find('.line-row');
                    
                    var last_tr = $('.unos-tabela').find('tr').last();
                    console.log($(last_tr));
                    var datum = $(last_tr).find('[name="datum[]"]').val();
                    var br_fakture = $(last_tr).find('[name="br_fakture[]"]').val();
                    var iznos = $(last_tr).find('[name="iznos[]"]').val();
                    var kolicina = $(last_tr).find('[name="kolicina[]"]').val();
                    var reg_vozila = $(last_tr).find('[name="reg_vozila[]"]').val();
                    console.log(cnt_tr.length);
                    if (cnt_tr.length > 1) {
                        if(datum == '' && br_fakture == '' && iznos == '' && kolicina == '' && reg_vozila == '') {
                            console.log('zadnji red prazan');
                            $(last_tr).remove();
                            $('.unos-tabela').find('tr').last().removeClass('cloned');
                            $('.overlay-loader').fadeIn();
                            $('#save-unos-form').submit();
                        } else if(datum == '' || br_fakture == '' || iznos == '' || kolicina == '' || reg_vozila == '') {
                            console.log('zadnji red nije popunjen');
                            swal({
                                title: "Pažnja!",
                                text: "U zadnjem redu nisu ispunjena potrebna polja!",
                                icon: "warning",
                                type: "warning",
                                showConfirmButton:false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok!'
                            });
                        } else {
                            console.log('pucaj');
                            $('.overlay-loader').fadeIn();
                            $('#save-unos-form').submit();
                        }       
                    }              

                });
                $('.zoom-img').click(function() {
                    var img = $(this).attr('src');
                    $('.img-preview-cont').html('<img src="'+img+'" style="height:100%;">');
                    $('.img-preview-cont').fadeIn();
                });
                $('.img-preview-cont').click(function() {
                    $(this).fadeOut();
                });
                $('body').keyup(function(event) {
                    console.log('auto clone');
                    var crr_row = event.target.closest('tr');
                    var hC = $(crr_row).hasClass('cloned');
                    var datum = $(crr_row).find('[name="datum[]"]').val();
                    var br_fakture = $(crr_row).find('[name="br_fakture[]"]').val();
                    var gorivo = $(crr_row).find('[name="gorivo[]"] option:selected').val();
                    var dobavljac = $(crr_row).find('[name="dobavljac[]"] option:selected').val();
                    var iznos = $(crr_row).find('[name="iznos[]"]').val();
                    var kolicina = $(crr_row).find('[name="kolicina[]"]').val();
                    var reg_vozila = $(crr_row).find('[name="reg_vozila[]"]').val();
                
                    if(datum != '' && br_fakture != '' && gorivo != '' && dobavljac != '' && iznos != '' && kolicina != '' && kolicina != '' && reg_vozila != '' && !hC) {
                        var coneldTr = $(crr_row).clone().appendTo($('.table'));
                        $(crr_row).addClass('cloned');
                        $(coneldTr).removeClass('cloned');
                        $(coneldTr).find('[name="iznos[]"]').val('');
                        $(coneldTr).find('[name="kolicina[]"]').val('');
                        $(coneldTr).find('[name="reg_vozila[]"]').val('');
                        $(coneldTr).appendTo('.table');
                        var i=1;
                        $('body').find('[name="br_pos[]"]').each(function() {
                            $(this).val(i);
                            i++;        
                        });
                    }

                });

                $('body').on('click', '.clone-row', function(event) {
                    
                    var crr_row = event.target.closest('tr');
                
                    var coneldTr = $(crr_row).clone();
                    $(coneldTr).find('[name="iznos[]"]').val('');
                    $(coneldTr).find('[name="kolicina[]"]').val('');
                    $(coneldTr).find('[name="reg_vozila[]"]').val('');
                    $(coneldTr).insertAfter($(crr_row));

                    $('.line-row').each(function() {
                        $(this).addClass('cloned');
                    });
                    $('body').find('.line-row').last().removeClass('cloned');
                    var i=1;
                    $('body').find('[name="br_pos[]"]').each(function() {
                        $(this).val(i);
                        i++;        
                    });
                    console.log('man clone');
                });

                $('body').on('click', '.del-row', function(event) {
                    var crr_row = event.target.closest('tr');
                    $(crr_row).remove();
                    $('.line-row').each(function() {
                        if(!$(this).hasClass('cloned')) {
                            $(this).addClass('cloned');
                        }
                    });
                    $('body').find('.line-row').last().removeClass('cloned');
                    var i=1;
                    $('body').find('[name="br_pos[]"]').each(function() {
                        $(this).val(i);
                        i++;        
                    });

                });
                

                $('body').on('click', '.dz-filename', function() {
                    var img = $(this).parent().parent().find('img').attr('src');
                    $('.prv-img').css('background-image', 'url('+img+')');
                    
                    $('.imgLightBox').modal('show');
                });

                
            </script>
            @stop
        @endif
    @endif
@endif
@endsection