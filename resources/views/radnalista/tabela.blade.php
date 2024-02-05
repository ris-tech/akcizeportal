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
@if(!$resp && !Auth::user()->hasRole('Admin'))
    <h1>Unošenje</h1>
    <div class="row">
        <div class="col-md-12 alert alert-warning text-center fw-bold">
            Nalog nepostojeći!
        </div>
    </div>  
@else
    @if($nalozi->unosilac_id != Auth::user()->id  && !Auth::user()->hasRole('Admin'))
        <h1>Unošenje</h1>
        <div class="row">
            <div class="col-md-12 alert alert-warning text-center fw-bold">
                Niste zadeljeni tom nalogu za unošenje!
            </div>
        </div>
    @else
        @if($nalozi->unos_gotov == 1  && !Auth::user()->hasRole('Admin'))
            <h1>Unošenje</h1>
            <div class="row">
                <div class="col-md-12 alert alert-warning text-center fw-bold">
                    Unos za taj nalog je završen!
                </div>
            </div>
        @else
            <div class="position-fixed bottom-0 end-0">
                {!! Form::open(array('route' => 'radnalista.finishUnos','id' => 'finish-unos-form','method'=>'POST')) !!}
                    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                    <input type="hidden" name="nalog_id" value="{{$nalozi->id}}">
                    <button class="btn btn-outline-success finish-unos" type="submit">Završi unos</button>
                {!! Form::close() !!}
            </div>
            <div class="row">
                <div class="col-md-8">
                    <h1>Izveštaj o nabavci i utrošku derivata</h1>
                </div>
                <div class="col-md-1">
                    <a href="{{route('radnalista.extImg', $nalozi->id)}}" class="btn btn-outline-success open-ext-img mb-2" type="button" target="_blank">Otvori externo</a>
                </div>
                <div class="col-md-1">
                    <input type="text" class="form-control sitesearch" placeholder="Pretraga">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">Sume</button>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-success save-table mb-2">Sačuvaj</button>
                    <button type="submit" class="save-table-final" hidden>Sačuvaj</button>
                </div>
            </div>
            <div class="row full-height">
                <div class="col-md-9">
                    @include('radnalista.rlhead')
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
                    {!! Form::open(array('route' => 'radnalista.store','id' => 'save-unos-form','method'=>'POST')) !!}
                    <input type="hidden" name="nalog_id" value="{{$nalozi->id}}">
                    @if($nalozi->taxi)
                    <input type="hidden" name="taxi" value="{{$nalozi->taxi}}">
                    @endif
                    
                    @if($tipVar != 'null')
                        <input type="hidden" name="tipVar" value="{{$tipVar}}">
                        <input type="hidden" name="tipId" value="{{$tipId}}">
                    @endif
                    <table class="table table-sm mt-3 unos-tabela">
                        <tr>
                            <th width="4%">Br.</th>
                            <th width="">Datum</th>
                            <th width="">BR. FAKTURE</th>
                            <th width="">BR. OTPREMNICE</th>
                            <th width="15%">VRSTA GORIVA</th>
                            <th width="15%">DOBAVLJAČ</th>
                            <th width="">IZNOS</th>
                            <th width="">KOLIČINA</th>
                            @if(!$nalozi->taxi)
                                <th width="14%">REG. BROJ</th>
                            @endif
                            <th width="9%">&nbsp;</th>
                        </tr>
                        @foreach($pozicije as $pozicija)
                        
                        <tr class="line-row cloned" id="{{$pozicija->broj_fakture}}">
                            @if($tipVar != 'null')
                                <input type="hidden" name="posId[]" value="{{$pozicija->id}}">
                            @endif
                            <td class="col_br_pos"><input type="text" readonly="readonly" value="{{$pos++}}" class="form-control" name="br_pos[]"></td>
                            <td><input class="form-control" type="date" name="datum[]" value="{{$pozicija->datum_fakture}}" min="{{$nalozi->kvartal['od']}}" max="{{$nalozi->kvartal['do']}}" required></td>
                            <td><input class="form-control" type="text" name="br_fakture[]" placeholder="BR. FAKTURE" value="{{$pozicija->broj_fakture}}" required></td>
                            <td><input class="form-control" type="text" name="br_opremnice[]" placeholder="BR. OPREMNICE" value="{{$pozicija->broj_opremnice }}"></td>
                            <td>@if($nalozi->evrodizel == 1 && $nalozi->tng == 1)
                                <select class="form-select" name="gorivo[]" required>
                                    <option value="" selected disabled>Izaberi</option>
                                    <option value="EVRO DIZEL" @if($pozicija->gorivo == 'EVRO DIZEL') selected @endif>EVRO DIZEL</option>
                                    <option value="TNG" @if($pozicija->gorivo == 'TNG') selected @endif>TNG</option>
                                </select>
                                @elseif($nalozi->evrodizel)
                                <select class="form-select" name="gorivo[]" required>
                                    <option value="EVRO DIZEL" selected>EVRO DIZEL</option>
                                </select>
                                @else
                                <select class="form-select" name="gorivo[]" required>
                                    <option value="TNG" selected>TNG</option>
                                </select> 
                                @endif
                                </td>
                            <td>
                                <select class="form-select" name="dobavljac[]" required>
                                    @foreach ($dobavljaci as $dobavljac)
                                    <option value="{{$dobavljac->id}}" @if($pozicija->dobavljac_id == $dobavljac->id) selected @endif>{{$dobavljac->ime}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="iznos[]" class="form-control" placeholder="0,00" value="{{str_replace('.', ',', $pozicija->iznos)}}">
                                    <span class="input-group-text p-1" style="font-size:10pt;">RSD</span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="kolicina[]" class="form-control" placeholder="0,00" value="{{str_replace('.', ',', $pozicija->kolicina)}}" required>
                                    <span class="input-group-text p-1" style="font-size:10pt;">L</span>
                                </div>
                            </td>
                            @if(!$nalozi->taxi)
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="reg_broj" name="reg_broj1[]" maxlength="2" placeholder="LO" value="{{$pozicija->reg_broj1}}" required>
                                    <span class="input-group-text p-1" style="text-size:10pt;">-</span>
                                    <input type="text" class="form-control" name="reg_broj2[]" placeholder="1234" maxlength="4" value="{{$pozicija->reg_broj2}}" required>
                                    <span class="input-group-text p-1" style="text-size:10pt;">-</span>
                                    <input type="text" class="form-control" name="reg_broj3[]" placeholder="XX" maxlength="2" value="{{$pozicija->reg_broj3}}" required>
                                </div>
                            </td>
                            @endif
                            <td class="text-end" align="right">
                                <div class="input-group text-end">
                                    <button type="button" class="btn btn-success btn-sm clone-row" data-bs-toggle="tooltip" data-bs-title="Dodaj red"><i class="fa-solid fa-plus"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm del-row" data-bs-toggle="tooltip" data-bs-title="Izbriši red"><i class="fa-solid fa-minus"></i></button>
                                </div>
                            </td>
                        </tr>        
                        @endforeach
                        <tr class="line-row">
                            <td class="col_br_pos"><input type="text" readonly="readonly" value="{{$pos++}}" class="form-control" name="br_pos[]"></td>
                            <td><input class="form-control" type="date" name="datum[]" required></td>
                            <td><input class="form-control" type="text" name="br_fakture[]" placeholder="BR. FAKTURE" required></td>
                            <td><input class="form-control" type="text" name="br_opremnice[]" placeholder="BR. OPREMNICE" required></td>
                            <td>@if($nalozi->evrodizel == 1 && $nalozi->tng == 1)
                                <select class="form-select" name="gorivo[]" required>
                                    <option value="" selected disabled>Izaberi</option>
                                    <option value="EVRO DIZEL">EVRO DIZEL</option>
                                    <option value="TNG">TNG</option>
                                </select>
                                @elseif($nalozi->evrodizel)
                                <select class="form-select" name="gorivo[]" required>
                                    <option value="EVRO DIZEL" selected>EVRO DIZEL</option>
                                </select>
                                @else
                                <select class="form-select" name="gorivo[]" required>
                                    <option value="TNG" selected>TNG</option>
                                </select> 
                                @endif
                                </td>
                            <td>
                                <select class="form-select" name="dobavljac[]" required> 
                                    <option value="" selected disabled>Izaberi</option>
                                    @foreach ($dobavljaci as $dobavljac)
                                    <option value="{{$dobavljac->id}}">{{$dobavljac->ime}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="iznos[]" class="form-control" placeholder="0,00">
                                    <span class="input-group-text p-1" style="font-size:10pt;">RSD</span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="kolicina[]" class="form-control" placeholder="0,00" required>
                                    <span class="input-group-text p-1" style="font-size:10pt;">L</span>
                                </div>
                            </td>
                            @if(!$nalozi->taxi)
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="reg_broj" name="reg_broj1[]" maxlength="2" placeholder="LO" value="{{old('reg_broj1')}}" required>
                                    <span class="input-group-text p-1" style="text-size:10pt;">-</span>
                                    <input type="text" class="form-control" name="reg_broj2[]" maxlength="4" placeholder="1234" value="{{old('reg_broj2')}}" required>
                                    <span class="input-group-text p-1" style="text-size:10pt;">-</span>
                                    <input type="text" class="form-control" name="reg_broj3[]" maxlength="2" placeholder="XX" value="{{old('reg_broj3')}}" required>
                                </div>
                            </td>
                            @endif
                            <td>
                                <div class="input-group buttonCol text-end">
                                    <button type="button" class="btn btn-success btn-sm clone-row" data-bs-toggle="tooltip" data-bs-title="Dodaj red"><i class="fa-solid fa-plus"></i></button>
                                    <!--<button type="button" class="btn btn-danger btn-sm del-row" data-bs-toggle="tooltip" data-bs-title="Izbriši red"><i class="fa-solid fa-minus"></i></button>-->
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-sm mt-3 total-suma-tabela table-dark">
                        <tr>
                            <th width="58%">Suma</th>
                            <th width="12%" class="total-suma-iznos ps-3 pe-0"></th>
                            <th width="10%" class="total-suma-kolicina ps-3 pe-0"></th>
                            <th width="23%">&nbsp;</th>
                        </tr>
                    </table>
                    <div class="deletedRows">

                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-3 border-start border-3 imgContainer">
                    <div class="full-height" style="overflow-y: auto;overflow-x: hidden;">
                        <div class="img-preview-cont text-center p-3" style="display: none;width:100%;width: -webkit-fill-available;width: -moz-available;width: stretch;">&nbsp;</div>
                        <div class="row mt-5">
                            @foreach($fajlovi as $fajl)
                            @php($filepos++)
                            <div class="col-md-6 mb-2 text-center">
                                <div style="width:100%">
                                @if($fajl->aktivan == 1)
                                    <img id="{{$filepos}}" src="{{$dokumenta_path.$fajl->folder.'/tmb/'.$fajl->fajl}}" original="{{$dokumenta_path.$fajl->folder.'/'.$fajl->fajl}}" style="max-width:100%;" class="border border-1 zoom-img">
                                    <div style="width:100%;" class="text-bg-secondary">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button class="btn btn-danger btn-sm delete-img delete-retrive-btn" id="{{$fajl->id}}">Izbriši</button> 
                                            </div>
                                            <div class="col-md-6 pt-1" style="font-size:10pt;">
                                                {{$filepos}} / {{$cntFiles}}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <img id="{{$filepos}}" src="{{$dokumenta_path.$fajl->folder.'/tmb/'.$fajl->fajl}}" original="{{$dokumenta_path.$fajl->folder.'/'.$fajl->fajl}}" style="max-width:100%;" class="border border-2 border-danger opacity-25 zoom-img">
                                    <div style="width:100%;" class="text-bg-secondary">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button class="btn btn-info btn-sm retrieve-img delete-retrive-btn" id="{{$fajl->id}}">Povrati</button>
                                            </div>
                                            <div class="col-md-6 pt-1" style="font-size:10pt;">
                                                {{$filepos}} / {{$cntFiles}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>
                            </div>
                            
                        @endforeach
                        </div>
                    </div>
                </div>

                <div class="modal fade nv-modal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">NV</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="nv-input">Kupljeno</label>
                                <div class="input-group">
                                    <input type="text" name="nv-input" class="form-control" placeholder="0,00">
                                    <input type="hidden" name="nv-brfakture">
                                    <span class="input-group-text" style="font-size:10pt;">L</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
                                <button type="button" class="btn btn-success save-nv">Unesi</button>
                            </div>
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
									<th>UKUPNI IZNOS</th>
                                    <th>UKUPNA KOLIČINA</th>
                                </tr>
                                @foreach($suma as $pos)
                                <tr>
                                    <th>{{$sumpos++}}</th>
                                    <th>{{$pos->reg_broj}}</th>
                                    <th>{{number_format($pos->iznos_goriva, 2, ',', '.')}} RSD</th>
                                    <th>{{number_format($pos->kol_goriva, 2, ',', '.')}} L</th>
                                </tr>
                                @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            
            
              
              
            
            @section('pagescript')
            <script type="text/javascript">
                var lastBrFakture = '';
                var lastIznos = 0;
                var lastKolicina = 0;
                var crrIznos = 0;
                var crrKolicina = 0;
                var startSum = 0;

                function makeFilterOptions(filter,sField) {
                    var options = [];
                    var output = '<option value="">Izaberi</option>';
                    $(filter).each(function() {
                        var crrBrFakture = $(this).val();
                        if (crrBrFakture != ''){
                            if(!options.includes(crrBrFakture)) {
                                options.push(crrBrFakture);
                            }
                        }
                    });
                    for(i=0;i<options.length;i++) {
                        output += '<option value="'+options[i]+'">'+options[i]+'</option>';
                    }
                    $(sField).html(output);
                }
                function getFajlStatus() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token() }}'
                        }
                    });
                    var request = $.ajax({
                        url: '{{route("radnalista.getFileStatus")}}',
                        method: 'POST',
                        data: {nalog_id: {{$nalozi->id}}},
                        dataType: 'json',
                        success: function(result){
                            $(result).each(function() {
                                let thisBtn = $('body').find('button#'+$(this)[0].fajl);
                                if($(this)[0].aktivan == '0') {
                                    $(thisBtn).removeClass('delete-img');
                                    $(thisBtn).removeClass('btn-danger');
                                    $(thisBtn).addClass('btn-info');
                                    $(thisBtn).addClass('retrieve-img');
                                    $(thisBtn).html('Povrati');
                                    $(thisBtn).parent().parent().find('img').addClass(['border','border-2','border-danger','opacity-25']);
                                    
                                } else {
                                    $(thisBtn).removeClass('retrieve-img');
                                    $(thisBtn).removeClass('btn-info');
                                    $(thisBtn).addClass('btn-danger');
                                    $(thisBtn).addClass('delete-img');
                                    $(thisBtn).html('Izbriši');
                                    $(thisBtn).parent().parent().find('img').removeClass(['border','border-2','border-danger','opacity-25']);
                                }
                            });
                            
                        }
                    });
                    setTimeout(() => {
                        getFajlStatus();                  
                    }, 1000);
                }

                getFajlStatus();         

                function calc_total_sum() {
                    let lastIznos = 0;
                    let lastKolicina = 0;

                    $('body').find('input[name="iznos[]"]').each(function() {
                        if ($(this).val() != '') {
                            let crrIznos = parseFloat($(this).val().replace(',', '.'));
                            console.log(crrIznos);
                            lastIznos = lastIznos + crrIznos;
                        }
                    });

                    $('body').find('input[name="kolicina[]"]').each(function() {
                        if ($(this).val() != '') {
                            let crrKolicina = parseFloat($(this).val().replace(',', '.'));
                            console.log(crrKolicina);
                            lastKolicina = lastKolicina + crrKolicina;
                        }
                    });

                    $('.total-suma-iznos').html($.number(lastIznos,2,',','.') + '<span class="pe-1" style="float:right;">RSD</span>');
                    $('.total-suma-kolicina').html($.number(lastKolicina,2,',','.') + '<span class="pe-1" style="float:right;">L</span>');

                }
                
                $('input[name="br_fakture[]"]').each(function() {
                    var crrBrFakture = $(this).val();
                    
                    var lineRow = $(this).parent().parent();
                    if(lastBrFakture != crrBrFakture) {
                        if(startSum == 0) {
                            startSum = 1;
                        } else {
                            $(lineRow).before('<tr class="sum" id="'+lastBrFakture+'">' +
                                '<td colspan="2" class="text-bg-secondary"><b>Suma</b></td>' +
                                '<td class="text-bg-secondary">'+lastBrFakture+'</td>' +
                                '<td colspan="3" class="text-bg-secondary">&nbsp;</td>' +
                                '<td class="text-bg-secondary sumIznos ps-2">'+$.number(lastIznos, 2, ',', '.')+' <span class="pe-1" style="float:right;">RSD</span></td>' +
                                '<td colspan="2" class="text-bg-secondary ps-2"><span class="sumKolicina">'+$.number(lastKolicina, 2, ',', '.')+'</span> L<span class="nv-icons"> / </span><span class="nv-kupljeno"></span><span class="nv-icons"> L<span class="nv-icons"> / </span></span> <span class="nv-total"></span><span class="nv-icons"> L</span></td>' +
                                '<td class="text-bg-secondary"><button type="button" class="btn btn-sm btn-outline-light py-0 nv-btn">NV</button></td>' +
                                '</tr>');
                            
                        }
                        lastIznos = 0;
                        lastKolicina = 0;
                        
                        var preIznos = $(lineRow).find('input[name="iznos[]"]').val();
                        if (preIznos != '') {
                            lastIznos = parseFloat($(lineRow).find('input[name="iznos[]"]').val().replace(',', '.'));
                        } else {
                            lastIznos = 0;
                        }

                        var preKolicina = $(lineRow).find('input[name="kolicina[]"]').val();
                        if (preKolicina != '') {
                            lastKolicina = parseFloat($(lineRow).find('input[name="kolicina[]"]').val().replace(',', '.'));
                        } else {
                            lastKolicina = 0;
                        } 
                        lastBrFakture = crrBrFakture;
                    } else {

                        var preIznos = $(lineRow).find('input[name="iznos[]"]').val();
                        if (preIznos != '') {
                            crrIznos = parseFloat($(lineRow).find('input[name="iznos[]"]').val().replace(',', '.'));
                        } else {
                            crrIznos = 0;
                        }
                        lastIznos = lastIznos+crrIznos;


                        var preKolicina = $(lineRow).find('input[name="kolicina[]"]').val();
                        if (preKolicina != '') {
                            crrKolicina = parseFloat($(lineRow).find('input[name="kolicina[]"]').val().replace(',', '.'));
                        } else {
                            crrKolicina = 0;
                        }                   
                        lastKolicina = lastKolicina+crrKolicina;
                    }
                });

                 
                $('.s_id').keyup(function() { 
                    var sval = $(this).val();
                    if (sval == '') {
                        $('.unos-tabela').find('[name="br_pos[]').each(function() {
                            $(this).parent().parent().show();
                        });
                    } else {
                        $('.unos-tabela').find('[name="br_pos[]').each(function() {
                            if($(this).val() == sval) {
                                $(this).parent().parent().show();
                            } else {
                                $(this).parent().parent().hide();
                            }
                        });
                    }

                });

                function reCalcIznos(brfakture) {
                    var iznos = 0;
                    var kolicina = 0;
                    var sumRow = $('body').find('[id="'+brfakture+'"].sum');
                    var sumIznos = $(sumRow).find('.sumIznos');
                    var sumKolicina = $(sumRow).find('.sumKolicina');
                    var iznosRow = $('body').find('[id="'+brfakture+'"].line-row').find('[name="iznos[]"]');
                    var kolicinaRow = $('body').find('[id="'+brfakture+'"].line-row').find('[name="kolinica[]"]');

                    $(iznosRow).each(function() {
                        var crrIznos = parseFloat($(this).val().replace(',','.'));
                        iznos = iznos+crrIznos;
                    });
                    $(kolicinaRow).each(function() {
                        var crrKolicina = parseFloat($(this).val().replace(',','.'));
                        kolicina = kolicina+crrKolicina;
                    });
                    $(sumIznos).html($.number(iznos,2,',','.')+' <span class="pe-1" style="float:right;">RSD</span>');
                    $(sumKolicina).html($.number(kolicina,2,',','.'));
                };

                function checkSumRow(){
                    $('body').find('.sum').each(function() {
                        var crrRow = $(this);
                        var prevRowHc = $(crrRow).prev().hasClass('line-row');
                        if (!prevRowHc) {
                            $(this).remove();
                        }
                    });
                }

                function reCalcPos() {
                    var i=1;
                    $('body').find('[name="br_pos[]"]').each(function() {
                        $(this).val(i);
                        i++;        
                    });
                }
                $('body').on('keyup', '[name="reg_broj1[]"]', function() {
                    $(this).val($(this).val().toUpperCase());
                });
                $('body').on('keyup', '[name="reg_broj2[]"]', function() {
                    $(this).val($(this).val().toUpperCase());
                });
                $('body').on('keyup', '[name="reg_broj3[]"]', function() {
                    $(this).val($(this).val().toUpperCase());
                });

                function chk_otpremnice() {
                    var unique_values = {};
                    let success = true;
                    $('body').find('[name="br_opremnice[]"]').each(function() {
                        var crrVal = $(this).val();
                        if(crrVal != '') {
                            if ( ! unique_values[crrVal] ) {
                                unique_values[crrVal] = true;
                                $(this).removeClass('is-invalid');
                            } else {
                                success = false;
                                $('body').find('input[name="br_opremnice[]"]').each(function() {
                                    if ($(this).val() == crrVal) {
                                        $(this).addClass('is-invalid');
                                    }
                                });
                            }
                        }
                    });
                    return success;
                }

                function msg_otpremnice() {
                    swal({
                        title: "Duplikat otpremince!",
                        text: "Duple otpremince nisu dozvoljene!",
                        icon: "error",
                        showConfirmButton:false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok!'
                    });
                }

                $('body').on('focusout', '[name="br_opremnice[]"]', function() {
                    if(!chk_otpremnice()) {
                        msg_otpremnice();
                    }
                });

                $('body').on('focusout', '[name="br_fakture[]"]', function() {
                    var thisfaktura = $(this);
                    var brfakture = $(this).val();
                    if (brfakture != '') {
                        var linerow = $(this).parent().parent();
                        var lastBrFakture = $(linerow).attr('id');
                        var hC = $(linerow).hasClass('cloned');
                        var hA = false;
                        var attr = $(linerow).attr('id');
                        
                        if (hC) {
                            if($(linerow).attr('id') != brfakture) {
                                var findRows = $('body').find('[id="'+brfakture+'"]');
                                if(findRows.length > 0) {
                                    swal({
                                        title: "Duplikat!",
                                        text: "Broj fakture je već korisćen!",
                                        icon: "warning",
                                        buttons: {
                                            cancel: {
                                                text: 'Odustani',
                                                visible: true,
                                            },
                                            confirm: {
                                                text: 'Potvrdi',
                                                visible: true,
                                            }
                                        }
                                    }).then((result) => {
                                        if (result) {
                                            var exBlock = $('body').find('[id="'+brfakture+'"].sum').first();
                                            var clonedRow = $(linerow).clone();
                                            $(clonedRow).attr('id', brfakture);
                                            $(exBlock).before(clonedRow);
                                            $(linerow).remove();
                                            $('body').find('[id="'+brfakture+'"].sum').first();
                                            checkSumRow();
                                            reCalcIznos(lastBrFakture);
                                            reCalcIznos(brfakture);
                                            reCalcPos();
                                        } else {
                                            $(thisfaktura).val('');
                                        }
                                    });
                                } else {
                                    var cloneRow = $(linerow);
                                    var iznos = parseFloat($(cloneRow).find('[name="iznos[]"]').val().replace(',','.'));
                                    var kolicina = parseFloat($(cloneRow).find('[name="kolicina[]"]').val().replace(',','.'));
                                    var crrRowId = $(linerow).attr('id');
                                    $('body').find('#'+crrRowId+'.sum').after(cloneRow);
                                    $(cloneRow).after('<tr class="sum" id="'+brfakture+'">' +
                                    '<td colspan="2" class="text-bg-secondary"><b>Suma</b></td>' +
                                    '<td class="text-bg-secondary">'+brfakture+'</td>' +
                                    '<td colspan="3" class="text-bg-secondary">&nbsp;</td>' +
                                    '<td class="text-bg-secondary sumIznos ps-2">'+$.number(iznos,2,',','.')+' <span class="pe-1" style="float:right;">RSD</span></td>' +
                                    '<td colspan="2" class="text-bg-secondary ps-2"><span class="sumKolicina">'+$.number(kolicina,2,',','.')+'</span> L<span class="nv-icons"> / </span><span class="nv-kupljeno"></span><span class="nv-icons"> L<span class="nv-icons"> / </span></span> <span class="nv-total"></span><span class="nv-icons"> L</span></td>' +
                                    '<td class="text-bg-secondary"><button type="button" class="btn btn-sm btn-outline-light py-0 nv-btn">NV</button></td>' +
                                    '</tr>');
                                    $(cloneRow).attr('id', brfakture);
                                    checkSumRow();
                                    reCalcIznos(lastBrFakture);
                                    reCalcIznos(brfakture);
                                    reCalcPos();
                                    //$(linerow).remove();
                                }
                            } else {
                                $(linerow).attr('id', brfakture);
                                checkSumRow();
                            }
                        } else {

                            var findRows = $('body').find('[id="'+brfakture+'"]');
                            if(findRows.length > 0) {
                                swal({
                                    title: "Duplikat!",
                                    text: "Broj fakture je već korisćen!",
                                    icon: "warning",
                                    buttons: {
                                        cancel: {
                                            text: 'Odustani',
                                            visible: true,
                                        },
                                        confirm: {
                                            text: 'Potvrdi',
                                            visible: true,
                                        }
                                    },
                                }).then((result) => {
                                    if (result) {
                                        var exBlock = $('body').find('[id="'+brfakture+'"].sum').first();
                                        var clonedRow = $(linerow).clone();
                                        $(clonedRow).attr('id', brfakture);
                                        $(exBlock).before(clonedRow);
                                        
                                        $('body').find('[id="'+brfakture+'"].sum').first();
                                        checkSumRow();
                                        reCalcIznos(lastBrFakture);
                                        reCalcIznos(brfakture);
                                    } else {
                                        $(thisfaktura).val('');
                                    }
                                });
                            }
                            $(linerow).attr('id', brfakture);
                            var coneldTr = $(linerow).clone();
                            $(coneldTr).removeAttr('id');
                            $(coneldTr).find('[name="datum[]"]').val('');
                            $(coneldTr).find('[name="br_fakture[]"]').val('');
                            $(coneldTr).find('[name="br_fakture[]"]').val('');
                            $(coneldTr).find('[name="dobavljac[]"] > option').each(function() {
                                $(this).removeAttr('selected');
                            });
                            $(coneldTr).find('[name="dobavljac[]"] > option[value=""]').attr('selected','');
                            $(coneldTr).find('[name="iznos[]"]').val('');
                            $(coneldTr).find('[name="kolicina[]"]').val('');
                            $(coneldTr).find('[name="reg_broj1[]"]').val('');
                            $(coneldTr).find('[name="reg_broj2[]"]').val('');
                            $(coneldTr).find('[name="reg_broj3[]"]').val('');
                            $('.unos-tabela').append(coneldTr);

                            $(linerow).after('<tr class="sum" id="'+brfakture+'">' +
                            '<td colspan="2" class="text-bg-secondary"><b>Suma</b></td>' +
                            '<td class="text-bg-secondary">'+brfakture+'</td>' +
                            '<td colspan="3" class="text-bg-secondary">&nbsp;</td>' +
                            '<td class="text-bg-secondary sumIznos ps-2">0,00 <span class="pe-1" style="float:right;">RSD</span></td>' +
                            '<td colspan="2" class="text-bg-secondary ps-2"><span class="sumKolicina">0,00</span> L<span class="nv-icons"> / </span><span class="nv-kupljeno"></span><span class="nv-icons"> L<span class="nv-icons"> / </span></span> <span class="nv-total"></span><span class="nv-icons"> L</span></td>' +
                            '<td class="text-bg-secondary"><button type="button" class="btn btn-sm btn-outline-light py-0 nv-btn">NV</button></td>' +
                            '</tr>');
                            $(linerow).addClass('cloned');
                            $(linerow).find('.clone-row').after('<button type="button" class="btn btn-danger btn-sm del-row" data-bs-toggle="tooltip" data-bs-title="Izbriši red"><i class="fa-solid fa-minus"></i></button>');
                            
                                
                            var i=1;
                            $('body').find('[name="br_pos[]"]').each(function() {
                                $(this).val(i);
                                i++;        
                            });
                        }
                    }

                });
                $('body').on('focusout', '[name="iznos[]"]', function() {
                    var brfakture = $(this).parent().parent().parent().attr('id');
                    var iznos = 0;
                    var rows = $('body').find('[id="'+brfakture+'"].line-row').each(function() {
                        var crriznos = $(this).find('input[name="iznos[]"]').val();
                        if (crriznos == '') {
                            crriznos = parseFloat(0.00);
                        } else {
                            crriznos = parseFloat($(this).find('input[name="iznos[]"]').val().replace(',','.'));
                        }
                        iznos = iznos+crriznos;
                    });
                    
                    var sumline = $('body').find('[id="'+brfakture+'"].sum > .sumIznos').html($.number(iznos, 2, ',', '.')+' <span class="pe-1" style="float:right;">RSD</span>');

                });
                $('body').on('focusout', '[name="kolicina[]"]', function() {
                    var brfakture = $(this).parent().parent().parent().attr('id');
                    var nvKupljeno = $('body').find('[id="'+brfakture+'"].sum').find('.nv-kupljeno').html();
                    
                    var kolicina = 0;
                    var rows = $('body').find('[id="'+brfakture+'"].line-row').each(function() {
                        var crrkolicina = $(this).find('input[name="kolicina[]"]').val();
                        if (crrkolicina == '') {
                            crrkolicina = parseFloat(0.00);
                        } else {
                            crrkolicina = parseFloat($(this).find('input[name="kolicina[]"]').val().replace(',','.'));
                        }
                        kolicina = kolicina+crrkolicina;
                    });
                    
                    var sumline = $('body').find('[id="'+brfakture+'"].sum').find('.sumKolicina').html($.number(kolicina, 2, ',', '.'));
                    if(nvKupljeno != '') {
                        
                        var nvKupljenoVal = parseFloat(nvKupljeno.replace('.','').replace(',','.'));
                        var total = kolicina-nvKupljenoVal;
                        var nvTotal = $('body').find('[id="'+brfakture+'"].sum').find('.nv-total').html($.number(total,2,',','.'));
                    }
                });
                $('[name="datum[]"]').focusout(function() {
                    var inpDate = new Date($(this).val());
                    var odDate = new Date("{{$nalozi->kvartal['od']}}");
                    var doDate = new Date("{{$nalozi->kvartal['do']}}");
                    if (inpDate < odDate){
                        $(this).addClass('is-invalid');
                    }
                    if (inpDate > doDate){
                        $(this).addClass('is-invalid');
                    }
                    
                    if (inpDate <= doDate && inpDate >= odDate){
                        $(this).removeClass('is-invalid');
                    }
                    
                });
                $('.save-table').click(function() {
                    var cnt_tr = $('body').find('.line-row');
                    var errDate = 0;
                    if(!chk_otpremnice()) {
                        msg_otpremnice();
                    }
                    $('body').find('[name="datum[]"]').each(function() {
                        if($(this).hasClass('is-invalid')) {
                            errDate = 1;
                        }
                    });


                    if (errDate == 1) {
                        swal({
                            title: "Pažnja!",
                            text: "U najmanje jednom polju je pogrešan datum unešen!",
                            icon: "warning",
                            showConfirmButton:false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok!'
                        });
                    } else {
                        var last_tr = $('.unos-tabela').find('tr').last();
                        var datum = $(last_tr).find('[name="datum[]"]').val();
                        var br_fakture = $(last_tr).find('[name="br_fakture[]"]').val();
                        var kolicina = $(last_tr).find('[name="kolicina[]"]').val();
                        var reg_broj1 = $(last_tr).find('[name="reg_broj1[]"]').val();
                        var reg_broj2 = $(last_tr).find('[name="reg_broj2[]"]').val();
                        var reg_broj3 = $(last_tr).find('[name="reg_broj3[]"]').val();
                        if (cnt_tr.length > 1) {
                            @if(!$nalozi->taxi)
                            if(datum == '' && br_fakture == '' &&  kolicina == '' && reg_broj1 == '' && reg_broj2 == '' && reg_broj3 == '') {
                            @else
                            if(datum == '' && br_fakture == '' &&  kolicina == '') {
                            @endif
                                
                                $('.unos-tabela').find('tr').last().removeClass('cloned');
                                $('body').find('tr.cloned').each(function() {
                                    if($(this).find('[name="datum[]"]').val() == '') {
                                        $(this).find('[name="datum[]"]').addClass('is-invalid');
                                    } else {
                                        $(this).find('[name="datum[]"]').removeClass('is-invalid');
                                    }
                                    if($(this).find('[name="br_fakture[]"]').val() == '') {
                                        $(this).find('[name="br_fakture[]"]').addClass('is-invalid');
                                    } else {
                                        $(this).find('[name="br_fakture[]"]').removeClass('is-invalid');
                                    }
                                    if($(this).find('[name="kolicina[]"]').val() == '') {
                                        $(this).find('[name="kolicina[]"]').addClass('is-invalid');
                                    } else {
                                        $(this).find('[name="kolicina[]"]').removeClass('is-invalid');
                                    }
                                    if($(this).find('[name="reg_broj1[]"]').val() == '') {
                                        $(this).find('[name="reg_broj1[]"]').addClass('is-invalid');
                                    } else {
                                        $(this).find('[name="reg_broj1[]"]').removeClass('is-invalid');
                                    }
                                    if($(this).find('[name="reg_broj2[]"]').val() == '') {
                                        $(this).find('[name="reg_broj2[]"]').addClass('is-invalid');
                                    } else {
                                        $(this).find('[name="reg_broj2[]"]').removeClass('is-invalid');
                                    }
                                    if($(this).find('[name="reg_broj3[]"]').val() == '') {
                                        $(this).find('[name="reg_broj3[]"]').addClass('is-invalid');
                                    } else {
                                        $(this).find('[name="reg_broj3[]"]').removeClass('is-invalid');
                                    }
                                });
                                var invalidInputs = $('body').find('.is-invalid');
                                if (invalidInputs.length > 0) {
                                    swal({
                                        title: "Pažnja!",
                                        text: "Neka polja nisu ispunjena ili imaju grešku!",
                                        icon: "warning",
                                        showConfirmButton:false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok!'
                                    });
                                } else {
                                    $(last_tr).remove();
                                    $('.overlay-loader').fadeIn();
                                    $('#save-unos-form').submit();
                                }
                                //$('.overlay-loader').fadeIn();
                                //$('.save-table-final').click();
                            
                            } else if(datum == '' || br_fakture == '' || kolicina == '' || reg_broj1 == '' || reg_broj2 == '' || reg_broj3 == '') {
                                swal({
                                    title: "Pažnja!",
                                    text: "U zadnjem redu nisu ispunjena potrebna polja!",
                                    icon: "warning",
                                    showConfirmButton:false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok!'
                                });
                            } else {
                                $('.overlay-loader').fadeIn();
                                $('#save-unos-form').submit();
                            }       
                        }       
                    }					

                });
                $('.zoom-img').click(function() {
                    var img = $(this).attr('original');
                    $('.img-preview-cont').html('<img src="'+img+'" style="max-width:100%;">');
                    $('.img-preview-cont').fadeIn();
                });
                $('.img-preview-cont').click(function() {
                    $(this).fadeOut();
                });

                $('body').on('click', '.delete-img', function() {
                    var thisBtn = $(this);
                    var fileid = $(this).attr('id');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    var request = $.ajax({
                        url: '{{route("radnalista.deleteFile")}}',
                        method: 'POST',
                        data: {fajl: fileid, nalog_id: {{$nalozi->id}}},
                        dataType: 'json',
                        success: function(result){
                            $(thisBtn).removeClass('delete-img');
                            $(thisBtn).removeClass('btn-danger');
                            $(thisBtn).addClass('btn-info');
                            $(thisBtn).addClass('retrieve-img');
                            $(thisBtn).html('Povrati fajl');
                            $(thisBtn).parent().parent().find('img').addClass(['border','border-2','border-danger','opacity-25']);
                        }
                    });
                });

                $('body').on('click', '.retrieve-img', function() {
                    var thisBtn = $(this);
                    var fileid = $(this).attr('id');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    var request = $.ajax({
                        url: '{{route("radnalista.retrieveFile")}}',
                        method: 'POST',
                        data: {fajl: fileid, nalog_id: {{$nalozi->id}}},
                        dataType: 'json',
                        success: function(result){
                            $(thisBtn).removeClass('retrieve-img');
                            $(thisBtn).removeClass('btn-info');
                            $(thisBtn).addClass('btn-danger');
                            $(thisBtn).addClass('delete-img');
                            $(thisBtn).html('Izbriši');
                            $(thisBtn).parent().parent().find('img').removeClass(['border','border-2','border-danger','opacity-25']);
                        }
                    });
                });

                $('body').find('.unos-tabel').keyup(function(event) {
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
                        var coneldTr = $(crr_row).clone();
                        $(crr_row).addClass('cloned');
                        $(coneldTr).removeClass('cloned');
                        $(coneldTr).find('[name="iznos[]"]').attr('value', '');
                        $(coneldTr).find('[name="kolicina[]"]').attr('value', '');
                        $(coneldTr).find('[name="reg_vozila[]"]').attr('value', '');
                        $(coneldTr).appendTo('.table');
                        reCalcPos();
                    }

                });
                function findNoDeleteButton() {
                    let deleteBtn = $('body').find('.cloned').find('.buttonCol').each(function() {
                        let deleteBtn = $(this).find('.del-row');
                        if (deleteBtn.length == 0) {
                            $(this).append('<button type="button" class="btn btn-danger btn-sm del-row" data-bs-toggle="tooltip" data-bs-title="Izbriši red"><i class="fa-solid fa-minus"></i></button>');
                        }
                    });
                }
                

                $('body').on('click', '.clone-row', function(event) {
                    
                    var crr_row = event.target.closest('tr');
                
                    var coneldTr = $(crr_row).clone();
                    $(coneldTr).find('[name="iznos[]"]').attr('value', '');
                    $(coneldTr).find('[name="kolicina[]"]').attr('value', '');
                    $(coneldTr).find('[name="reg_vozila[]"]').attr('value', '');
                    $(coneldTr).insertAfter($(crr_row));

                    $('.line-row').each(function() {
                        $(this).addClass('cloned');
                    });
                    $('body').find('.line-row').last().removeClass('cloned');
                    reCalcPos();
                    findNoDeleteButton();
                });
                $('body').on('change', 'select[name="dobavljac[]"]', function() {
                    var selOption = $(this).children("option:selected").val();
                    $(this).find("option").each(function() {
                        $(this).removeAttr('selected');
                    });
                    $(this).find('option[value="'+selOption+'"]').attr('selected','');
                });

                $('body').on('click', '.del-row', function(event) {
                    var crr_row = event.target.closest('tr');
                    var brfakture = $(crr_row).attr('id');
                    var posId = $(crr_row).find('input[name="posId[]"]').clone();
                    @if($tipVar != 'null')
                        $(posId).attr('name', 'delPos[]');
                        $('.deletedRows').append(posId);    
                    @endif

                    $(crr_row).remove();
                    $('.line-row').each(function() {
                        if(!$(this).hasClass('cloned')) {
                            $(this).addClass('cloned');
                        }
                    });
                    $('body').find('.line-row').last().removeClass('cloned');
                    reCalcPos();

                    var iznos = 0;
                    var rows = $('body').find('[id="'+brfakture+'"].line-row').each(function() {
                        var crriznos = $(this).find('input[name="iznos[]"]').val();
                        if (crriznos == '') {
                            crriznos = parseFloat(0.00);
                        } else {
                            crriznos = parseFloat($(this).find('input[name="iznos[]"]').val().replace(',','.'));
                        }
                        iznos = iznos+crriznos;
                    });
                    
                    var sumline = $('body').find('[id="'+brfakture+'"].sum > .sumIznos').html($.number(iznos, 2, ',', '.')+' RSD');
                    checkSumRow();

                });


                $('body').on('click', '.nv-btn', function() {
                    var brfakture = $(this).parent().parent().attr('id');
                    $('[name="nv-brfakture"]').val(brfakture);
                    $('.nv-modal').modal('show');
                    $('[name="nv-input"]').focus();
                });

                $('.save-nv').click(function() {
                    var nv = parseFloat($('[name="nv-input"]').val().replace(',','.'));
                    var brfakture = $('[name="nv-brfakture"]').val();
                    if (nv != '0') {
                        var sumKolicina = parseFloat($('body').find('[id="'+brfakture+'"].sum').find('.sumKolicina').html().replace('.','').replace(',','.'));
                        var calcNV = sumKolicina-nv;
                        $('body').find('[id="'+brfakture+'"].sum').find('.nv-kupljeno').html($.number(nv,2,',','.'));
                        $('body').find('[id="'+brfakture+'"].sum').find('.nv-total').html($.number(calcNV,2,',','.'));
                        $('body').find('[id="'+brfakture+'"].sum').find('.nv-icons').each(function() {
                            $(this).show();
                        });
                    } else {
                        $('body').find('[id="'+brfakture+'"].sum').find('.nv-kupljeno').html('');
                        $('body').find('[id="'+brfakture+'"].sum').find('.nv-total').html('');
                        $('body').find('[id="'+brfakture+'"].sum').find('.nv-icons').each(function() {
                            $(this).hide();
                        });
                    }
                    $('.nv-modal').modal('hide');
                    $('[name="nv-input"]').val('');
                    $('[name="nv-brfakture"]').val('');
                });

                calc_total_sum();
                
            </script>
            @stop
        @endif
    @endif
@endif
@endsection