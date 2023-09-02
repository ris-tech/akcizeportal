@extends('layouts.app-wm')

@section('pagestyle')
    <style>

.full-img {
    width:100%;
}
.img-preview-cont {
    position: absolute;
    background-color: rgba(0, 0, 0, 0.5);
    width:100%;
    height:80%;
}
.imgbtn {
    cursor: pointer;
    transition: 200ms;
}
.imgbtn:hover {
    font-size: 2.8rem !important;
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
            <div class="row full-height">
                <div class="col-md-10 text-center position-relative full-height">
                    
                    <img src="{{$dokumenta_path.$fajlovi[0]->fajl}}" style="height:100%" id="0" class="border border-1 big-img">
                    
                    <div class="row position-fixed bottom-0 bg-secondary" style="width:100px;height:500px">
                        <div class="col-md-12">
                            <div class="text-light fs-1 imgbtn next-img"><i class="fa-solid fa-circle-arrow-right"></i></div>
                            <div class="text-light fs-1 imgbtn prev-img"><i class="fa-solid fa-circle-arrow-left"></i></div>
                            <div class="text-light fs-1 imgbtn zoom-in"><i class="fa-solid fa-circle-plus"></i></div>
                            <div class="text-light fs-1 imgbtn zoom-out"><i class="fa-solid fa-circle-minus"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 border-start border-3">
                    <div class="full-height" style="overflow-y: auto;overflow-x: hidden;">
                        <div class="row">
                            @foreach($fajlovi as $fajl)
                            <div class="col-md-6 mb-2">
                                <img src="{{$dokumenta_path.$fajl->fajl}}" style="width:100%;" class="border open-img @if($i == 0) border-primary border-5 @else border-1 @endif" id="{{$i++}}">
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            
            @section('pagescript')
            <script type="text/javascript">
                $('.next-img').click(function() {
                    var crrImg = $('.big-img').attr('id');
                    var nextImg = parseInt(crrImg)+1;
                    var getNextImg = $('.open-img#'+nextImg).attr('src');
                    if (typeof getNextImg !== "undefined") {
                        $('.big-img').attr('id', nextImg);
                        $('.big-img').attr('src', getNextImg);
                    }
                });
                $('.prev-img').click(function() {
                    var crrImg = $('.big-img').attr('id');
                    if(crrImg > 0) {
                        var nextImg = parseInt(crrImg)-1;
                        var getNextImg = $('.open-img#'+nextImg).attr('src');
                        $('.big-img').attr('id', nextImg);
                        $('.big-img').attr('src', getNextImg);
                    }
                });
                $('.open-img').click(function() {
                    var imgSrc = $(this).attr('src');
                    $('body').find('.border-primary').each(function() {
                        $(this).removeClass('border-primary border-5');
                    });
                    $(this).addClass('border-primary border-5');
                    $('.big-img').attr('src', imgSrc);
                });
                $('.zoom-in').click(function() {

                    var bigimg = $('.big-img').height();
                    var newheight = bigimg + 200;
                    $('.big-img').height(newheight);
                });
                $('.zoom-out').click(function() {

                    var bigimg = $('.big-img').height();
                    var newheight = bigimg - 200;
                    $('.big-img').height(newheight);
                });
            </script>
            @stop
        @endif
    @endif
@endif
@endsection