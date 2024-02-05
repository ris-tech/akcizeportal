@extends('layouts.app')

@section('content')

<div class='context-menu-dobavljac'>
    <div class="list-group">
        <a href="" class="list-group-item list-group-item-action cmd-tabela" target="_blank"><i class="fa-solid fa-table"></i> Tabela utrošak</a>
        <a href="" class="list-group-item list-group-item-action cmd-dobavljac" target="_blank"><i class="fa-solid fa-oil-well"></i> Izmeni dobavljača</a>
    </div>
</div>

{!! Form::open(array('route' => 'izvestajOPlacanju.store','method'=>'POST')) !!}
<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
<input type="hidden" name="nalog_id" value="{{$nalozi->id}}">
<div class="row">
    <div class="col-md-6">
        <h1>Izveštaji o plaćanju derivata - Izvodi</h1>
    </div>
    <div class="col-md-6 text-end">
        <button class="btn btn-outline-success finish-unos" type="submit">Sačuvaj</button>
        <a href="{{ route('radnalista.tabela', $nalozi->id) }}" class="btn btn-outline-dark" target="_blank">Tabela utrošak</a>
        <a href="{{ route('radnalista.extImg', ['id' => $nalozi->id, 'tip' => 'sken_izvodi']) }}" class="btn btn-outline-dark" target="_blank">Otvori externo</a>
    </div>
</div>


    
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div>
@endif        
    
@include('radnalista.rlhead')


<div class="row mt-3 mb-3">
    @foreach($dobavljaci as $dobavljac)
    <input type="hidden" name="dobavljac_id[]" value="{{$dobavljac->dobavljac_id}}">
    <div class="col-md-12 mb-5">
        <table class="table table-sm table-striped izvestaj" id="{{$dobavljac->dobavljac_id}}">
            <thead>
                <tr>
                    <th colspan="8" class="text-center text-bg-secondary dobavljacId" id="{{$dobavljac->dobavljac_id}}"><h2>{{$dobavljac->dobavljac->ime}}</h2></th>
                </tr>
                <tr>
                    <th class="noCalc" width="4%">R.Br.</th>
                    <th class="noCalc" width="16%">Broj</th>
                    <th class="noCalc" width="10%">Datum</th>
                    <th class="noCalc" width="20%">Naziv banke</th>
                    <th class="noCalc" addon="L" addonVal="RSD" width="10%">Iznos</th>
                    <th class="noCalc" width="16%">Napomena</th>
                    <th class="noCalc" width="16%">Vezni dokument</th>
                    <th class="noCalc" width="14%">&nbsp;</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($pozicije[$dobavljac->dobavljac_id] as $pozicija)
                @php($binDocUid = uniqid())
                <tr class="line-row cloned" id="{{$dobavljac->dobavljac_id}}" uniqId="{{$binDocUid}}">
                    <td class="col_br_pos">
                        <input type="text" readonly="readonly" value="{{ $loop->iteration }}" class="form-control" name="br_pos[{{$dobavljac->dobavljac_id}}][]">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="broj[{{$dobavljac->dobavljac_id}}][]" value="{{$pozicija->broj}}">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="datum[{{$dobavljac->dobavljac_id}}][]" value="{{$pozicija->datum}}">
                    </td>
                    <td>
                        <select class="form-select" name="banka_id[{{$dobavljac->dobavljac_id}}][]">
                            <option value="">Izaberi</option>
                            @foreach($banke as $banka)
                            <option value="{{$banka->id}}" @if($pozicija->banka_id == $banka->id)selected @endif>{{$banka->ime}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="iznos[{{$dobavljac->dobavljac_id}}][]" value="{{$pozicija->iznos}}">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="napomena[{{$dobavljac->dobavljac_id}}][]" value="{{$pozicija->napomena}}">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="vezni_dokument[{{$dobavljac->dobavljac_id}}][]" value="{{$pozicija->vezni_dokument}}">
                    </td>
                    <td class="bindDocTd">
                        <div class="input-group">
                            <button type="button" class="btn btn-success btn-sm clone-row" data-bs-toggle="tooltip" data-bs-title="Dodaj red"><i class="fa-solid fa-plus"></i></button>
                            <button type="button" class="btn btn-danger btn-sm del-row" data-bs-toggle="tooltip" data-bs-title="Izbriši red"><i class="fa-solid fa-minus"></i></button>
                            <span style="border: dotted 2px #333;width:30px;height:30px;" class="position-relative openBindDocModal" data-draggable="target" id="{{$dobavljac->dobavljac_id}}">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info cntIds">@if($pozicija->bindDoc != '' || $pozicija->bindDoc != 'null')@if(str_contains($pozicija->bindDoc, '|')){{count(explode('|',$pozicija->bindDoc))}}@else 0 @endif @endif</span>
                            </span>
                            <input type="hidden" class="bindDoc" name="bindDoc[{{$dobavljac->dobavljac_id}}][]" value="{{$pozicija->bindDoc}}">
                        </div>
                        
                    </td>
                </tr>  
                @endforeach  
                @php($newBinDocUid = uniqid())
                <tr class="line-row" id="{{$dobavljac->dobavljac_id}}" uniqId="{{$newBinDocUid}}">
                    
                    <td class="col_br_pos"><input type="text" readonly="readonly" value="" class="form-control" name="br_pos[{{$dobavljac->dobavljac_id}}][]"></td>
                    <td>
                        <input type="text" class="form-control" name="broj[{{$dobavljac->dobavljac_id}}][]">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="datum[{{$dobavljac->dobavljac_id}}][]">
                    </td>
                    <td>
                        <select class="form-select" name="banka_id[{{$dobavljac->dobavljac_id}}][]">
                            <option value="">Izaberi</option>
                            @foreach($banke as $banka)
                            <option value="{{$banka->id}}">{{$banka->ime}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="iznos[{{$dobavljac->dobavljac_id}}][]">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="napomena[{{$dobavljac->dobavljac_id}}][]">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="vezni_dokument[{{$dobavljac->dobavljac_id}}][]">
                    </td>
                    <td class="bindDocTd">
                        <div class="input-group">
                            <button type="button" class="btn btn-success btn-sm clone-row" data-bs-toggle="tooltip" data-bs-title="Dodaj red"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </td>
                    
                </tr> 
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-bg-dark fw-bold">&nbsp;</td>
                    <td class="text-bg-dark fw-bold">&nbsp;</td>
                    <td class="text-bg-dark fw-bold">&nbsp;</td>
                    <td class="text-bg-dark fw-bold text-end">Ukupno: </td>
                    <td class="text-bg-dark fw-bold suma_iznosa">RSD 0,00</td>
                    <td class="text-bg-dark fw-bold">&nbsp;</td>
                    <td class="text-bg-dark fw-bold">&nbsp;</td>
                    <td class="text-bg-dark fw-bold">&nbsp;</td>
                </tr>
            </tfoot>
        </table>
        <table class="table table-sm table-striped">
            <tr>
                <td class="text-center">Ukupno nabavljeno naftnih derivata za kvartal iznosi:</td>
                <td>RSD</td>
                <td class="nabavljeno" id="{{ $dobavljac->dobavljac_id }}">{{ number_format($dobavljac->SUMIZNOS,2,',','.') }}</td>
            </tr>
            <tr>
                <td class="text-center">Ukupno uplaćeno:</td>
                <td>RSD</td>
                <td class="uplaceno" id="{{ $dobavljac->dobavljac_id }}">0,00</td>
            </tr>
            <tr>
                <td class="text-center">Razlika:</td>
                <td>RSD</td>
                <td class="razlika" id="{{ $dobavljac->dobavljac_id }}">0,00</td>
            </tr>
        </table>
    </div>
    @endforeach
</div>
<div class="modal fade h-100" id="bindDocModal" tabindex="-1" aria-labelledby="bindDocModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl h-100">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bindDocModalLabel">Nakačeni Fajilovi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="min-height:calc(100vh - 200px);">
                <div class="big-img-cont" style="position: absolute;width:100%;height:100%;background-color: rgba(0,0,0,0.7);z-index:99999999;display:none;text-align:center;" class="text-center">
                    <img src="" style="height:100%;">
                </div>
                <div class="row bindDocModalCont">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
            </div>
        </div>
    </div>
</div>
  
{!! Form::close() !!}
@section('pagescript')
    <script type="text/javascript">
        $('body').on('click', '.open-big', function() {
            let url = $(this).attr('original');
            $('.big-img-cont').find('img').attr('src', url);
            $('.big-img-cont').fadeIn();
        });

        $('.big-img-cont').click(function() {
            $('.big-img-cont').fadeOut();
            $('.big-img-cont').find('img').attr('src', '');
        });

        $("#bindDocModal").on('hide.bs.modal', function(){
            $('.big-img-cont').find('img').attr('src', '');
            $('.big-img-cont').fadeOut();
            $('.bindDocModalCont').html('');
        });

        $('body').on('click', '.remove-bindDoc', function() {
            let dobavljac_id = $(this).attr('dobavljacId');
            let bindDocUid = $(this).attr('uniqId');
            console.log(bindDocUid);
            let fajl_id = $(this).attr('id');
            $('body').find('#'+fajl_id+'.tmb-img').remove();
            let bindDocIds = $('body').find('tr[uniqId="'+bindDocUid+'"]').find('input[name="bindDoc[6][]"]').val();
            
            console.log(bindDocIds);
            let newbindDocIds = bindDocIds.replace(fajl_id,'');
            newbindDocIds = newbindDocIds.replace('||','|');   
            console.log(newbindDocIds);
            $('body').find('tr[uniqId="'+bindDocUid+'"]').find('input[name="bindDoc[6][]"]').val(newbindDocIds);
            let cntIds = parseInt($('body').find('tr[uniqId="'+bindDocUid+'"]').find('.cntIds').html());
            newCntIds = cntIds-1;
            if(newCntIds == 0) {
                $('body').find('tr[uniqId="'+bindDocUid+'"]').find('input[name="bindDoc[6][]"]').val('');
            }
            $('body').find('tr[uniqId="'+bindDocUid+'"]').find('.cntIds').html(newCntIds);
        });

        $('body').on('click', '.openBindDocModal', function() {

            var bindDocUid = $(this).closest('tr').attr('uniqId');
            var bindDocIds = $(this).parent().find('.bindDoc').val();
            let dobavljac_id = $(this).attr('id');
            if(bindDocIds != '') {
                let content = '';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                var request = $.ajax({
                    url: '{{route("izvestajOPlacanju.getBindDocs")}}',
                    method: 'POST',
                    data: {files: bindDocIds},
                    dataType: 'json',
                    success: function(response){
                        console.log(response.fajlovi);
                        var resp = response.fajlovi;
                        var cntFiles = resp.length;

                        for (let i=0; cntFiles>i; i++) {
                            console.log(response.fajlovi[i].fajl);
                            content += '<div class="col-md-3 position-relative tmb-img" id="'+response.fajlovi[i].id+'"><div class="position-absolute"><button type="button" class="btn btn-sm btn-danger remove-bindDoc" id="'+response.fajlovi[i].id+'" dobavljacId="'+dobavljac_id+'" uniqId="'+bindDocUid+'">Otkači</button></div><img class="shadow border border-3 open-big" src="'+response.fajlovi[i].tmb+'" original="'+response.fajlovi[i].fajl+'" style="width:100%;">' +
                                '</div>';
                        }
                        $('.bindDocModalCont').html(content);
                    }
                });            
                $('#bindDocModal').modal('show');
            } else {
                swal({
                    title: "Paznja",
                    text: "Nema povezanih fajlova!",
                    icon: "warning",
                    type: "warning",
                    showConfirmButton:false,
                    confirmButtonText: 'Yes, delete it!'
                });
            }
        });
 


    $(document).ready(function(){

        if (!document.querySelectorAll || !('draggable' in document.createElement('span')) || window.opera) { return; }

        //get the collection of draggable items and add their draggable attribute
        for(var items = document.querySelectorAll('[data-draggable="item"]'), len = items.length, i = 0; i < len; i ++)
        {
            items[i].setAttribute('draggable', 'true');
        }

        var item = null;

        //dragstart event to initiate mouse dragging
        document.addEventListener('dragstart', function(e)
        {
            localStorage.setItem('currentDragElement', e.target.id);
            e.dataTransfer.setData("text/plain", e.target.id);

        }, false);

        document.addEventListener('dragenter', function(e) {
            event.preventDefault();
        });

        document.addEventListener('dragover', function(e) {
            event.preventDefault();
        });
        document.addEventListener('drop', function(e)
        {
            e.stopPropagation();
            e.preventDefault();   
            console.log(e);
            if(e.target.dataset.draggable == 'target')
            {           

                console.log(localStorage.getItem('currentDragElement'));

                if(localStorage.getItem('currentDragElement') == e.target.dataset.fileid) {
                    return;
                }
                
                if(e.target.getAttribute('data-draggable') == 'target')
                {
                    var dobavljac_id = e.target.getAttribute('id');
                    if($('body').find('input[name="bindDoc['+dobavljac_id+'][]"][value="'+localStorage.getItem('currentDragElement')+'"]').length == 0) {
                        var crrVal = $(e.target).parent().find('input[name="bindDoc['+dobavljac_id+'][]"]').val();
                        var cntIds = 0;
                        console.log(cntIds);
                        if(crrVal.includes('|')) {
                            cntIds = crrVal.split("|").length;
                        } else if(crrVal != '') {
                            cntIds = 1;
                        }
                        console.log(cntIds);
                        if(crrVal == '') {
                            $(e.target).parent().find('input[name="bindDoc['+dobavljac_id+'][]"]').val(localStorage.getItem('currentDragElement'));
                        } else {
                            $(e.target).parent().find('input[name="bindDoc['+dobavljac_id+'][]"]').val(crrVal+'|'+localStorage.getItem('currentDragElement'));
                        }
                        cntIds = parseInt(cntIds)
                        cntIds++;
                        console.log(cntIds);
                        $(e.target).find('.cntIds').html(cntIds);
                    }
                }

                console.log(e.target);

                localStorage.setItem('currentDragElement', null);

                return false;
            }

        }, false);

        $('.izvestaj').each(function() {
            var dobavljac_id = $(this).attr('id');
            reCalcPos(dobavljac_id);

        });
        $('body').on('click', '.clone-row', function(event) {
            
            var crr_row = event.target.closest('tr');
            var dobavljac_id = $(crr_row).parent().parent().attr('id');
        
            var clonedTr = $(crr_row).clone();
            $(clonedTr).find('input').each(function() {
                $(this).val('');
                $(this).attr('value','');
            });
            $(clonedTr).find('.binDoc').val('');
            $(clonedTr).find('.cntIds').html('0');
            
            $(clonedTr).insertAfter($(crr_row));

            $('table#'+dobavljac_id).find('.line-row').each(function() {
                $(this).addClass('cloned');
            });
            $('body').find('table#'+dobavljac_id).find('.line-row').last().removeClass('cloned');
            reCalcPos(dobavljac_id);
            putDelRow(dobavljac_id);
            chkBindDoc();
        });

        function chkBindDoc() {
            $('body').find('.cloned').each(function() {
                let dobavljac_id = $(this).attr('id');
                let binDoc = $(this).find('.bindDoc');
                if(binDoc.length == 0) {
                    let out = '<span style="border: dotted 2px #333;width:30px;height:30px;" class="position-relative openBindDocModal" data-draggable="target" id="'+dobavljac_id+'">' +
                                '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info cntIds">0</span>' +
                            '</span><input type="hidden" class="bindDoc" name="bindDoc['+dobavljac_id+'][]" value="">';
                    $(this).find('.bindDocTd').find('.input-group').append(out);
                }
                
            });
        }

        function reCalcPos(dobavljac_id) {
            var i=1;
            $('body').find('[name="br_pos['+dobavljac_id+'][]"]').each(function() {
                $(this).val(i);
                i++;     
            });
        }

        function putDelRow(dobavljac_id) {
            $('table#'+dobavljac_id).find('.cloned').find('.clone-row').each(function() {
                var parent = $(this).parent();
                var delrowBtn = $(parent).find('.del-row');
                if(delrowBtn.length == 0) {
                    $(this).after('<button type="button" class="btn btn-danger btn-sm del-row" data-bs-toggle="tooltip" data-bs-title="Izbriši red"><i class="fa-solid fa-minus"></i></button>');
                }
            });
        }


        $('body').on('click', '.del-row', function(event) {
            var parent = event.target.closest('table');
            var dobavljac_id = $(parent).attr('id');
            var crr_row = event.target.closest('tr');

            $(crr_row).remove();
            $('.line-row').each(function() {
                if(!$(this).hasClass('cloned')) {
                    $(this).addClass('cloned');
                }
            });
            $('table#'+dobavljac_id).find('.line-row').last().removeClass('cloned');
            reCalcPos(dobavljac_id);
            reCalcRazliku(dobavljac_id);
        });

        function reCalcRazliku(dobavljac_id) {
            var uplaceno = 0;
            $('body').find('table#'+dobavljac_id).find('input[name="iznos[]"]').each(function() {
                if ($(this).val() != '') {
                    var iznos = parseFloat($(this).val().replace('.','').replace(',','.'));
                    uplaceno = uplaceno+iznos;
                }
            });
            var nabavljeno = parseFloat($('#'+dobavljac_id+'.nabavljeno').text().replace('.','').replace(',','.'));
            var razlika = uplaceno-nabavljeno;
            $('#'+dobavljac_id+'.uplaceno').html($.number(uplaceno,2,',','.'));
            $('#'+dobavljac_id+'.razlika').html($.number(razlika,2,',','.'));
        }

        $('body').on('focusout', 'input[name="iznos[]"]', function(event) {
            console.log('drin');
            var parent = event.target.closest('table');
            var dobavljac_id = $(parent).attr('id');
            reCalcRazliku(dobavljac_id);
        });
        
        
        $('.nabavljeno').each(function() {
            var dobavljac_id = $(this).attr('id');
            var nabavljeno = parseFloat($(this).text().replace('.','').replace(',','.'));
            var uplaceno = parseFloat($('#'+dobavljac_id+'.uplaceno').text().replace('.','').replace(',','.'));
            var razlika = uplaceno-nabavljeno;
            $('#'+dobavljac_id+'.razlika').html($.number(razlika,2,',','.'));
        });

        $(".dobavljacId").bind('contextmenu', function (e) {
            var dobavljacId = $(this).attr('id');
            var baseurl =  "{{ route('radnalista.tabela', ['id' => $nalozi->id, 'tip' => 'poDobavljacu']) }}";
            var url = baseurl+'/'+dobavljacId; 
            this.href = url;
            $('.cmd-tabela').prop("href", url);
            $('.cmd-dobavljac').prop('href', 'https://portal.akcize.rs/dobavljaci/'+dobavljacId+'/edit');
            var top = e.pageY+5;
            var left = e.pageX;

            // Show contextmenu
            $(".context-menu-dobavljac").toggle(100).css({
                top: top + "px",
                left: left + "px"
            });

            // disable default context menu
            return false;
        });

        // Hide context menu
        $(document).bind('contextmenu click',function(){
            
            $(".context-menu").hide();
            $(".context-menu-dobavljac").hide();

        });

        $('.context-menu-dobavljac').bind('contextmenu',function(){
            return false;
        });

        $('.context-menu .cmd-tabela').click(function(){
            $(".context-menu-dobavljac").hide();
        });

        $('.cmd-dobavljac').click(function(){
            swal({
                title: "Paznja",
                text: "Sačuvaj izveštaj za novu proveru dobavljaca",
                icon: "warning",
                type: "warning",
                showConfirmButton:false,
                confirmButtonText: 'Yes, delete it!'
            });
            $(".context-menu-dobavljac").hide();
        });

    });
    </script>
@stop
@endsection