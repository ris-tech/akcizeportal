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
    background-size: cover;
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
@if(!$resp)
    <h1>Skeniranje</h1>
    <div class="row">
        <div class="col-md-12 alert alert-warning text-center fw-bold">
            Nalog nepostojeći!
        </div>
    </div>  
@else
    @if($nalozi->skener_id != Auth::user()->id)
        <h1>Skeniranje</h1>
        <div class="row">
            <div class="col-md-12 alert alert-warning text-center fw-bold">
                Niste zadeljeni tom nalogu za skeniranje!
            </div>
        </div>
    @else
        @if($nalozi->sken_gotov == 1)
            <h1>Skeniranje</h1>
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
                    <button class="btn btn-outline-success finish-scan" type="submit">Završi skeniranje</button>
                {!! Form::close() !!}
                </div>
            <h1>Skeniranje</h1>
            @include('radnalista.rlhead')
            <div class="row mt-3">
                <div class="col-md-12">
                    <form action="{{ route('radnalista.storeFiles') }}" method="post" enctype="multipart/form-data" id="image-upload" class="dropzone">
                        @csrf
                        <input type="hidden" name="klijent_id" value="{{ $nalozi->klijent['id'] }}">
                        <input type="hidden" name="nalog_id" value="{{ $nalozi->id }}">
                        @foreach($fajlovi as $fajl)
                            <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete"> 
                                <div class="dz-image">
                                    <img class="prw_img" data-dz-thumbnail="" alt="" src="{{ $dokumenta_path.$fajl->fajl}}">
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
                Dropzone.autoDiscover = false;
                var dropzone = new Dropzone('#image-upload', {
                    init: function () {
                        this.on("addedfile",function(file) {
                            
                        });
                        this.on("complete", function (file) {
                            console.log(file);
                            var lastCont = file.previewElement;
                            
                            var resp = file.xhr.response;
                            var resp_json = $.parseJSON(resp);
                            $(lastCont).find('.delete-img').attr('file-id',resp_json.file);
                            console.log(resp_json);
                        });
                    },
                    thumbnailWidth: null,
                    thumbnailHeight: null,
                    acceptedFiles: ".jpeg,.jpg,.png,.gif",
                    previewTemplate: document.querySelector('#tpl').innerHTML,

                
                });

                $('body').on('click', '.dz-filename', function() {
                    var img = $(this).parent().parent().find('img').attr('src');
                    $('.prv-img').css('background-image', 'url('+img+')');
                    
                    $('.imgLightBox').modal('show');
                });

                $('body').on('click', '.delete-img', function() {
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
                        url: '{{route("radnalista.deleteFile")}}',
                        method: 'POST',
                        data: {nalog_id: nalogid,klijent_id: klijentid, fajl: fileid},
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