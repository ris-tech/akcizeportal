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
    @if($nalozi->unosilac_id != Auth::user()->id && !Auth::user()->hasRole('Admin'))
        <h1>Unošenje</h1>
        <div class="row">
            <div class="col-md-12 alert alert-warning text-center fw-bold">
                Niste zadeljeni tom nalogu za unošenje!
            </div>
        </div>
    @else
        @if($nalozi->unos_gotov == 1 && !Auth::user()->hasRole('Admin'))
            <h1>Unošenje</h1>
            <div class="row">
                <div class="col-md-12 alert alert-warning text-center fw-bold">
                    Unos za taj nalog je završen!
                </div>
            </div>
        @else
            <div class="row full-height">
                <div class="col-md-10 text-center position-relative full-height">
                    @if(empty($fajlovi[0]))
                        Nema Fajilova
                    @else
                        <img src="{{$dokumenta_path.$fajlovi[0]->folder.'/'.$fajlovi[0]->fajl}}" style="height:100%" id="0" class="border border-1 big-img">
                    @endif
                    <div class="row position-fixed bottom-0 bg-secondary" style="width:100px;height:500px">
                        <div class="col-md-12">
                            <div class="text-light fs-1 imgbtn next-img"><i class="fa-solid fa-circle-arrow-right"></i></div>
                            <div class="text-light fs-1 imgbtn prev-img"><i class="fa-solid fa-circle-arrow-left"></i></div>
                            <div class="text-light fs-1 imgbtn zoom-in"><i class="fa-solid fa-circle-plus"></i></div>
                            <div class="text-light fs-1 imgbtn zoom-out"><i class="fa-solid fa-circle-minus"></i></div>
                            <div class="text-light fs-6 mt-3 imgId">1 / {{$cntFiles}}</div>

                        </div>
                    </div>
                </div>
                <div class="col-md-2 border-start border-3">
                    <div class="full-height" style="overflow-y: auto;overflow-x: hidden;">
                        <div class="row position-fixed">
                            <div class="col-md-12">
                                <input type="text" class="form-control sitesearch" placeholder="Pretraga">
                            </div>
                        </div>
                        <div class="row" data-draggable="target">
                            
                            @foreach($fajlovi as $fajl)
                            @php($i++)
                            <div class="col-md-6 mb-2">
                                @if($fajl->aktivan == 1)
                                <img data-draggable="item" id="{{$i}}" src="{{$dokumenta_path.$fajl->folder.'/tmb/'.$fajl->fajl}}" original="{{$dokumenta_path.$fajl->folder.'/'.$fajl->fajl}}" data-fileId="{{$fajl->id}}" style="width:100%;" class="border open-img @if($i == 0) border-primary border-5 @else border-1 @endif">
                                <div style="width:100%;" class="text-bg-secondary">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-danger btn-sm delete-img delete-retrive-btn" id="{{$fajl->id}}">Izbriši</button> 
                                        </div>
                                        <div class="col-md-6 pt-1" style="font-size:10pt;">
                                            {{$i}} / {{$cntFiles}}
                                        </div>
                                    </div>
                                </div>
                                @else
                                <img data-draggable="item" id="{{$i}}" src="{{$dokumenta_path.$fajl->folder.'/tmb/'.$fajl->fajl}}" original="{{$dokumenta_path.$fajl->folder.'/'.$fajl->fajl}}" data-fileId="{{$fajl->id}}" style="width:100%;" class="border open-img border border-2 border-danger opacity-25 zoom-img">
                                <div style="width:100%;" class="text-bg-secondary">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-info btn-sm retrieve-img delete-retrive-btn" id="{{$fajl->id}}">Povrati</button> 
                                        </div>
                                        <div class="col-md-6 pt-1" style="font-size:10pt;">
                                            {{$i}} / {{$cntFiles}}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            
            @section('pagescript')
            <script type="text/javascript">

        (function()
        {

        //exclude older browsers by the features we need them to support
        //and legacy opera explicitly so we don't waste time on a dead browser
            if (!document.querySelectorAll || !('draggable' in document.createElement('span')) || window.opera) { return; }

            //get the collection of draggable items and add their draggable attribute
            for(var items = document.querySelectorAll('[data-draggable="item"]'), len = items.length, i = 0; i < len; i ++)
            {
                items[i].setAttribute('draggable', 'true');
            }

            var item = null;
            document.addEventListener('dragstart', function(e)
            {
                console.log(e.target.dataset.fileid);
                localStorage.setItem('currentDragElement', e.target.dataset.fileid);
                e.dataTransfer.setData("text/plain", e.target.dataset.fileid);

            }, false);
        })(); 

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
                            $(thisBtn).parent().parent().parent().parent().find('img').addClass(['border-2','border-danger','opacity-25']);
                            
                        } else {
                            $(thisBtn).removeClass('retrieve-img');
                            $(thisBtn).removeClass('btn-info');
                            $(thisBtn).addClass('btn-danger');
                            $(thisBtn).addClass('delete-img');
                            $(thisBtn).html('Izbriši');
                            $(thisBtn).parent().parent().parent().parent().find('img').removeClass(['border-2','border-danger','opacity-25']);
                        }
                    });
                    
                }
            });
            setTimeout(() => {
                getFajlStatus();                  
            }, 1000);
        }

        getFajlStatus();    

                $('body').on('click', '.delete-img', function() {
                    var thisBtn = $(this);
                    var fileid = $(this).attr('id');
                    $('.overlay-loader').fadeIn();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token() }}'
                        }
                    });
                    var request = $.ajax({
                        url: '{{route("radnalista.deleteFile")}}',
                        method: 'POST',
                        data: {nalog_id: {{$nalozi->id}}, fajl: fileid},
                        dataType: 'json',
                        success: function(result){
                            $(thisBtn).removeClass('delete-img');
                            $(thisBtn).removeClass('btn-danger');
                            $(thisBtn).addClass('btn-info');
                            $(thisBtn).addClass('retrieve-img');
                            $(thisBtn).html('Povrati fajl');
                            $(thisBtn).parent().parent().find('img').addClass(['border','border-2','border-danger','opacity-25']);
                            $('.overlay-loader').fadeOut();
                        }
                    });
                });
                $('body').on('click', '.retrieve-img', function() {
                    var thisBtn = $(this);
                    var fileid = $(this).attr('id');
                    $('.overlay-loader').fadeIn();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        }
                    });
                    var request = $.ajax({
                        url: '{{route("radnalista.retrieveFile")}}',
                        method: 'POST',
                        data: {nalog_id: {{$nalozi->id}}, fajl: fileid},
                        dataType: 'json',
                        success: function(result){
                            $(thisBtn).removeClass('retrieve-img');
                            $(thisBtn).removeClass('btn-info');
                            $(thisBtn).addClass('btn-danger');
                            $(thisBtn).addClass('delete-img');
                            $(thisBtn).html('Izbriši');
                            $(thisBtn).parent().parent().find('img').removeClass(['border','border-2','border-danger','opacity-25']);
                            $('.overlay-loader').fadeOut();
                        }
                    });
                });
                $('.sitesearch').on('keypress', function (e) {
                    if(e.which === 13){
                        var imgId = e.target.value;
                        console.log(imgId);
                        $('.full-height').find('.bg-info').each(function() {
                            $(this).removeClass('bg-info');
                        });
                        
                        $('.full-height').animate({
                            scrollTop: $("#"+imgId+".open-img").offset().top-150
                        }, 1000);
                        $("#"+imgId+".open-img").parent().addClass('bg-info');
                    }
                });                

                $('.next-img').click(function() {
                    var crrImg = $('.big-img').attr('id');
                    var nextImg = parseInt(crrImg)+1;
                    var getNextImg = $('.open-img#'+nextImg).attr('original');
                    $('body').find('.border-primary').each(function() {
                        $(this).removeClass('border-primary border-5');
                    });
                    $('.open-img#'+nextImg).addClass('border-primary border-5');
                    if (typeof getNextImg !== "undefined") {
                        $('.big-img').attr('id', nextImg);
                        $('.big-img').attr('src', getNextImg);
                        $('.imgId').html(nextImg+' / {{$cntFiles}}');
                    }
                });
                $('.prev-img').click(function() {
                    var crrImg = $('.big-img').attr('id');
                    if(crrImg > 0) {
                        var nextImg = parseInt(crrImg)-1;
                        $('body').find('.border-primary').each(function() {
                            $(this).removeClass('border-primary border-5');
                        });
                        $('.open-img#'+nextImg).addClass('border-primary border-5');
                        var getNextImg = $('.open-img#'+nextImg).attr('original');
                        $('.big-img').attr('id', nextImg);
                        $('.big-img').attr('src', getNextImg);
                        $('.imgId').html(nextImg+' / {{$cntFiles}}');
                    }
                });
                $('.open-img').click(function() {
                    var imgSrc = $(this).attr('original');
                    var imgID = $(this).attr('id');
                    $('body').find('.border-primary').each(function() {
                        $(this).removeClass('border-primary border-5');
                    });
                    $(this).addClass('border-primary border-5');
                    $('.big-img').attr('src', imgSrc);
                    $('.big-img').attr('id', imgID);
                    $('.imgId').html(imgID+' / {{$cntFiles}}');
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