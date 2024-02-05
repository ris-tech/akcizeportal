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
<div class="container">
    <div class="row justify-content-between mb-5">
        <div class="col-md-10">
            <h2>{{$tipName}} od Klijenta: <b>{{ $klijent->naziv }}</b></h2>
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
    <div class="row mt-3">
        <div class="col-md-12">
            <form action="{{ route('dokumenta.storeFiles') }}" method="post" enctype="multipart/form-data" id="image-upload" class="dropzone">
                @csrf
                <input type="hidden" name="klijent_id" value="{{ $klijent->id }}">
                <input type="hidden" name="tip" value="{{ $tip }}">
                @foreach($dokumenta as $dokument)
                    <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                        <div class="dz-image">
                            <img class="prw_img" data-dz-thumbnail="" alt="" src="@if($dokument->folder == NULL){{ $dokumenta_path.$tip.'/tmb/'.$dokument->tmb }}@else{{ $dokumenta_path.$tip.'/'.$dokument->folder.'/tmb/'.$dokument->tmb }}@endif" original="@if($dokument->folder == NULL){{ $dokumenta_path.$tip.'/'.$dokument->fajl}}@else{{ $dokumenta_path.$tip.'/'.$dokument->folder.'/'.$dokument->fajl}}@endif">
                        </div>
                        <div class="dz-details">
                            <div class="dz-filename" original="@if($dokument->folder == NULL){{ $dokumenta_path.$tip.'/'.$dokument->fajl}}@else{{ $dokumenta_path.$tip.'/'.$dokument->folder.'/'.$dokument->fajl}}@endif">
                                <span data-dz-name="{{$dokument->id}}">{{$dokument->fajl}}</span>
                            </div>
                            <div class="dz-options">
                                <button type="button" class="btn btn-danger delete-img" file-id="{{$dokument->fajl}}" tmb="{{$dokument->tmb}}"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="text-bg-secondary dz-filename" original="@if($dokument->folder == NULL){{ $dokumenta_path.$tip.'/'.$dokument->fajl}}@else{{ $dokumenta_path.$tip.'/'.$dokument->folder.'/'.$dokument->fajl}}@endif" style="position: absolute;bottom:0;z-index:100;word-break: break-word;width: 200px;cursor:pointer;font-size:10pt;">{{$dokument->fajl}}</div>
                    </div>
                @endforeach
            </form>
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
    <div class="modal-dialog modal-dialog-centered modal-xl" style="max-height:100%;max-width:90%;width:90%;">
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
@endsection
@section('pagescript')
<script type="text/javascript">
    $('body').find('.progress').each(function() {
        $(this).show();
    });
    $('.process-details-global').show();


    function numProc(hidden_folder, zip_uid, klijent_id, tip, uuid, cntFiles) {
        $('body').find('.progress').each(function() {
            $(this).show();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });
        var request_num = $.ajax({ 
            url: '{{route("dokumenta.getProc")}}',
            method: 'POST',
            data: {klijent: hidden_folder, uid: zip_uid, tip: tip},
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
                        setTimeout(numProc(hidden_folder, zip_uid, klijent_id, tip, uuid, cntFiles), 1000);
                    } else {
                        
                        $('.progress-bar-file-process-'+uuid).removeClass('progress-bar-primary');
                        $('.progress-bar-file-process-'+uuid).addClass('bg-success');
                        if (procFile == pdfFiles) {
                            console.log('Total Finish');
                        }
                        procFileProgress++;
                    }
                } else {
                    setTimeout(numProc(hidden_folder, zip_uid, klijent_id, tip, uuid, cntFiles), 1000);
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
    var dropzone = new Dropzone('#image-upload', {
        init: function () {
            this.on("sending", function(file, xhr, formData) {
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
                var xhrResp = $.parseJSON(response.xhr.response);
                console.log(xhrResp);
                /*if(xhrResp.resp.ext == 'pdf') {
                    var hidden_folder = xhrResp.resp.hiddenFolder;
                    var new_file = xhrResp.resp.new_file;
                    var zip_uid = xhrResp.resp.zip_uid;
                    var klijent_id = xhrResp.resp.klijent_id;
                    var tip = xhrResp.resp.tip;
                    var uuid = xhrResp.resp.uuid;
                    var cntFiles = xhrResp.resp.cntFiles;
                    var filename = xhrResp.resp.filename;
                    

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
                    var request = $.ajax({ 
                        url: '{{route("dokumenta.processPDFs")}}',
                        method: 'POST',
                        data: {hiddenfolder: hidden_folder, new_file: new_file, zip_uid: zip_uid, klijent_id: klijent_id, tip: tip},
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
                    
                    
                    
                    numProc(hidden_folder, zip_uid, klijent_id, tip, uuid, cntFiles);
                    
                    
                    if (crrFiles != pdfFiles) {
                        crrFiles++;
                        $('.process-details-global').html('Upload Fajl '+crrFiles+' / '+pdfFiles);
                    } else {
                        $('.process-details-global').html('Upload Fajlova završen! ('+pdfFiles+')');
                        $('.progress-upload').removeClass('progress-bar-primary');
                        $('.progress-upload').addClass('bg-success');
                    }
                    
                    procFile++;
                } else {
                    
                }*/
                if (crrFiles != pdfFiles) {
                    crrFiles++;
                    $('.process-details-global').html('Upload Fajl '+crrFiles+' / '+pdfFiles);
                } else {
                    window.location = window.location;
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
        var pdf = $(this).attr('original');
        $('.pdf-frame').attr('src', pdf);
        $('#pdf-modal').modal('show');
    });

    $('body').on('click', '.delete-img', function() {
        var thisBtn = $(this);
        var fileid = $(this).attr('file-id');
        var tmb = $(this).attr('tmb');
        var nalogid = $('body').find('input[name="nalog_id"]').val();
        var klijentid = $('body').find('input[name="klijent_id"]').val();
        swal({
                title: "Siguran?",
                text: "Jel si siguran da hoćes da izbrišes dokument?",
                icon: "warning",
                type: "warning",
                buttons: ["Odustani","Da!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Da, izbriši!'
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    var request = $.ajax({
                        url: '{{route("dokumenta.deleteFile")}}',
                        method: 'POST',
                        data: {nalog_id: nalogid,klijent_id: klijentid, fajl: fileid, tip: '{{ $tip }}', tmb: tmb},
                        dataType: 'json',
                        success: function(result){
                            $(thisBtn).parent().parent().parent().remove();
                        }
                    });
                }
            });
    });
    $('body').on('click', '.retrieve-img', function() {
        var thisBtn = $(this);
        var fileid = $(this).attr('file-id');
        var klijentid = $('body').find('input[name="klijent_id"]').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });
        var request = $.ajax({
            url: '{{route("dokumenta.retrieveFile")}}',
            method: 'POST',
            data: {klijent_id: klijentid, fajl: fileid},
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
