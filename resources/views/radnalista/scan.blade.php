@extends('layouts.app')

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
    background-size: contain;
}
.dz-options {
    margin-top: 1em;
}
.full-img {
    width:100%;
}
        </style>
@stop

@section('content')
<div class="row">
    <div class="col-md-10">
        <h1>Skeniranje - {{$tip_ime}}</h1>
    </div>
    <div class="col-md-2 text-end">
        <a class="btn btn-outline-secondary" href="{{ route('radnalista.selectScan',['id'=>$nalozi->id]) }}"> Nazad</a>
    </div>
</div>

@if(!$resp)
    <div class="row">
        <div class="col-md-12 alert alert-warning text-center fw-bold">
            Nalog nepostojeći!
        </div>
    </div>
@else
    @if($nalozi->{$v_tip} != Auth::user()->id)
        <div class="row">
            <div class="colmd-12 alert alert-warning text-center fw-bold">
                Niste zadeljeni tom nalogu za skeniranje!
            </div>
        </div>
    @else
        @if($nalozi->{$tip} == 1)
            <div class="row">
                <div class="col-md-12 alert alert-warning text-center fw-bold">
                    Skeniranje za taj nalog je završen!
                </div>
            </div>
            @else
            <div class="position-fixed bottom-0 end-0">
                {!! Form::open(array('route' => 'radnalista.finishScan','id' => 'finish-scan-form','method'=>'POST')) !!}
                    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
                    <input type="hidden" name="nalog_id" value="{{$nalozi->id}}">
                    <input type="hidden" name="tip" value="{{$tip}}">
                    <button class="btn btn-outline-success finish-scan" type="submit">Završi skeniranje</button>
                {!! Form::close() !!}
                </div>
            @include('radnalista.rlhead')
            <div class="row mt-3">
                <div class="col-md-3 mb-2">
                    @if($tip == 'sken_izvodi')
                    <label for="sken_banka"><strong>Banka</strong></label>
                    <select class="form-select sken_banka" id="sken_banka" name="sken_banka">
                        <option value="">Izaberi banku</option>
                        @foreach($banke as $banka)
                            <option value="{{$banka->id}}">{{$banka->ime}}</option>
                        @endforeach
                    @endif
                    </select>
                </div>
                <div class="col-md-12">
                    <form action="{{ route('radnalista.storeFiles') }}" method="post" enctype="multipart/form-data" id="image-upload" class="dropzone">
                        @csrf
                        <input type="hidden" name="klijent_id" value="{{ $nalozi->klijent['id'] }}">
                        <input type="hidden" name="nalog_id" value="{{ $nalozi->id }}">
                        <input type="hidden" name="tip" value="{{ $tip }}">
                        @foreach($fajlovi as $fajl)
                            <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                <div class="dz-image">
                                    <img class="prw_img" data-dz-thumbnail="" alt="" src="{{ $dokumenta_path.$fajl->folder.'/tmb/'.$fajl->fajl }}" original="{{ $dokumenta_path.$fajl->folder.'/'.$fajl->fajl}}">
                                </div>
                                <div class="dz-details">
                                    <div class="dz-filename">
                                        <span data-dz-name="{{$fajl->id}}">{{$fajl->id}}</span>
                                    </div>
                                    <div class="dz-options">
                                        <button type="button" class="btn btn-danger delete-img" file-id="{{$fajl->fajl}}"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </form>
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
            <div id="tpl" style="display:none;">
                <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                    <div class="dz-image">
                        <img class="prw_img" data-dz-thumbnail="" alt="" src="">
                    </div>
                    <div class="dz-details">
                        <div class="dz-size">
                            <span data-dz-size=""><strong></strong> MB</span>
                        </div>
                        <div class="dz-filename">
                            <span data-dz-name=""></span>
                        </div>
                        <div class="dz-options">
                            <button type="button" class="btn btn-danger delete-img"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                    <div class="dz-success-mark"><span><i class="fa-regular fa-circle-check"></i></span></div>
                    <div class="dz-error-mark"><span><i class="fa-regular fa-circle-xmark"></i></span></div>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                </div>
            </div>
            @section('pagescript')
            <script type="text/javascript">
				$('body').find('.progress').each(function() {
                    $(this).show();
                });
				$('.process-details-global').show();


                function numProc(hidden_folder, zip_uid, nalog_id, uuid, cntFiles) {
                    $('body').find('.progress').each(function() {
                        $(this).show();
                    });
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    var request_num = $.ajax({ 
                        url: '{{route("radnalista.getProc")}}',
                        method: 'POST',
                        data: {klijent: hidden_folder, uid: zip_uid, nalog: nalog_id},
                        dataType: 'json',
                        success: function(result_num){

                            let resp = $.parseJSON(result_num.files);
                            let cntProcFiles = resp.files;

                            if($.isNumeric(cntProcFiles)) {
                                var calcProz = (cntProcFiles / cntFiles) * 100;
                                var filesProz = Math.round(calcProz);
                                var prozBar = $('.progress-bar-file-process-'+uuid); 
                                $(prozBar).css("width", filesProz + "%");
                                $(prozBar).html(cntProcFiles + "/" + cntFiles);
                                if(cntProcFiles != cntFiles) {
                                    $('.progress-bar-file-process-'+uuid).removeClass('bg-success');
                                    $('.progress-bar-file-process-'+uuid).addClass('progress-bar-primary');
                                    setTimeout(numProc(hidden_folder, zip_uid, nalog_id, uuid, cntFiles), 1000);
                                } else {
                                    
                                    $('.progress-bar-file-process-'+uuid).removeClass('progress-bar-primary');
                                    $('.progress-bar-file-process-'+uuid).addClass('bg-success');
                                    if (procFile == pdfFiles) {
                                        console.log('Total Finish');
                                    }
                                    procFileProgress++;
                                }
                            } else {
                                setTimeout(numProc(hidden_folder, zip_uid, nalog_id, uuid, cntFiles), 1000);
                            }
                        }
                    });
                }


				let completeFileArr = {};
				let cntFiles = [];
				let pdfFiles = 0;
				let crrFiles = 1;
				let procFile = 0;
				let finFiles = 0;
                let procFileProgress = 0;
                
				let processDetailsGlobal = '';
				let processDetailsSingle = '';
                Dropzone.autoDiscover = false;

                function chk_banka(){
                    var success = true;
                    var selectedBanka = $('.sken_banka option:selected').val();
                    console.log(selectedBanka);
                    if(selectedBanka == '') {
                        success = false;
                        swal({
                            title: "Izaberi banku!",
                            text: "Da bi uneo fajilove moraš kao prvo izabrati banku!",
                            icon: "error",
                            showConfirmButton:false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok!'
                        });
                    }
                    return success;
                }

                var dropzone = new Dropzone('#image-upload', {
                    init: function () {
                        this.on("sending", function(file, xhr, formData) {
                            if(!chk_banka()) {
                                this.removeFile(file);
                                $('.overlay-loader').fadeOut();
                            }
                            formData.append('uuid', file.upload.uuid);
                            formData.append('filename', file.name);
                        });
                        this.on("uploadprogress", function (file, progress) {
                            var progressBar = $(".progress-upload");
                            $(progressBar).css("width", Math.round(progress) + "%");
                            $(progressBar).html(Math.round(progress) + "%");
                            
                        });
                        this.on("addedfile",function(files) {
							pdfFiles++;            
							$('.process-details-global').html('Upload Fajl 1/'+pdfFiles);
							$('.overlay-loader').fadeIn();
						});
						this.on("complete", function (response) {
                            console.log(response.xhr.response);
                            if(response.xhr.response != '') {
                                
                                var xhrResp = $.parseJSON(response.xhr.response);
                                var hidden_folder = xhrResp.resp.hiddenFolder;
                                var new_file = xhrResp.resp.new_file;
                                var zip_uid = xhrResp.resp.zip_uid;
                                var nalog_id = xhrResp.resp.nalog_id;
                                var tip = xhrResp.resp.tip;
                                var uuid = xhrResp.resp.uuid;
                                var cntFiles = xhrResp.resp.cntFiles;
                                var filename = xhrResp.resp.filename;
                                var sken_tip = '';

                                $tmpl = '<span class="process-details-single-'+uuid+' text-light">Preradjivanje Fajla: '+filename+'</span>' +
                                    '<div class="progress">' +
                                        '<div class="progress-bar progress-bar-file-process-'+uuid+' progress-bar-primary" role="progressbar">' +
                                            '<span class="progress-text"></span>' +
                                        '</div>' +
                                    '</div>';
                                $('.overlay__content').append($tmpl);
                                
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                                    }
                                });
                                console.log(hidden_folder);
                                console.log(new_file);
                                console.log(zip_uid);
                                console.log(nalog_id);
                                console.log(tip);
                                if(tip == 'sken_izvodi') {
                                    var bankaId = $('.sken_banka option:selected').val();
                                }
                                
                                var request = $.ajax({ 
                                    url: '{{route("radnalista.processPDFs")}}',
                                    method: 'POST',
                                    data: {hiddenfolder: hidden_folder, new_file: new_file, zip_uid: zip_uid, nalog_id: nalog_id, tip: tip, banka: bankaId},
                                    dataType: 'json',
                                    success: function(result){
                                        finFiles++;
                                        
                                        let files = result.resp;
                                        if($.isNumeric(files)) {
                                            if (finFiles == pdfFiles) {
                                                window.location = window.location;
                                            }
                                        }
                                    }
                                });
                                
                                
                                
                                numProc(hidden_folder, zip_uid, nalog_id, uuid, cntFiles);
                                
                                
                                if (crrFiles != pdfFiles) {
                                    crrFiles++;
                                    $('.process-details-global').html('Upload Fajl '+crrFiles+' / '+pdfFiles);
                                } else {
                                    $('.process-details-global').html('Upload Fajlova završen! ('+pdfFiles+')');
                                    $('.progress-upload').removeClass('progress-bar-primary');
                                    $('.progress-upload').addClass('bg-success');
                                }
                                
                                procFile++;
                            }
						});
                    },
                    thumbnailWidth: null,
                    thumbnailHeight: null,
					parallelUploads: 1,
					autoProcessQueue: true,
                    acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
                    previewTemplate: document.querySelector('#tpl').innerHTML,


                });

                $('body').on('click', '.dz-filename', function() {
                    var img = $(this).parent().parent().find('img').attr('original');
                    $('.prv-img').css('background-image', 'url('+img+')');

                    $('.imgLightBox').modal('show');
                });

                $('body').on('click', '.delete-img', function() {
                    var thisBtn = $(this);
                    var fileid = $(this).attr('file-id');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    var request = $.ajax({
                        url: '{{route("radnalista.deleteFile")}}',
                        method: 'POST',
                        data: {fajl: fileid, nalog_id: '{{$nalozi->id}}'},
                        dataType: 'json',
                        success: function(result){
                            $(thisBtn).html('<i class="fa-solid fa-rotate-left"></i>');
                            $(thisBtn).removeClass('delete-img');
                            $(thisBtn).removeClass('btn-danger');
                            $(thisBtn).addClass('btn-info');
                            $(thisBtn).addClass('retrieve-img');
                            $(thisBtn).parent().parent().parent().find('.dz-image').addClass(['border','border-2','border-danger','opacity-25']);
                        }
                    });
                });
                $('body').on('click', '.retrieve-img', function() {
                    var thisBtn = $(this);
                    var fileid = $(this).attr('file-id');
                    var nalogid = $('body').find('input[name="nalog_id"]').val();
                    var klijentid = $('body').find('input[name="klijent_id"]').val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    var request = $.ajax({
                        url: '{{route("radnalista.retrieveFile")}}',
                        method: 'POST',
                        data: {nalog_id: nalogid,klijent_id: klijentid, fajl: fileid},
                        dataType: 'json',
                        success: function(result){
                            $(thisBtn).html('<i class="fa-solid fa-trash"></i>');
                            $(thisBtn).removeClass('retrieve-img');
                            $(thisBtn).removeClass('btn-info');
                            $(thisBtn).addClass('btn-danger');
                            $(thisBtn).addClass('delete-img');
                            $(thisBtn).parent().parent().parent().find('.dz-image').removeClass(['border','border-2','border-danger','opacity-25']);
                        }
                    });
                });
            </script>
            @stop
        @endif
    @endif
@endif
@endsection
