@extends('layouts.app')
@section('pagestyle')
    <style>
        td, th {
            padding-top:6px;padding-bottom:6px;
        }
    </style>
@stop
@section('content')
    <div class="row justify-content-between mb-5">
        <div class="col-md-10">
            <h2>PEP-Obrazac Klijenta: <b>{{ $klijent->naziv_lat }}</b></h2>
        </div>
        <div class="col-md-2 text-end">
            <a class="btn btn-outline-secondary" href="{{ route('dokumenta.show', $klijent->id) }}"> Nazad</a>
        </div>
    </div>

    <table class="table table-borderless" style="font-size:8pt;">
        <tr>
            <th colspan="5" class="border-1 border-black" style="background-color: #c1c1c1;"><b>ОВЛАШЋЕЊЕ ЗА УПОТРЕБУ ЕЛЕКТРОНСКИХ СЕРВИСА</b></th>
            <th colspan="2" class="border-1 border-black" style="background-color: #c1c1c1;" ><b>Образац ПЕП</b></th>
        </tr>
        <tr>
            <td colspan="7"><i>1. подаци о пореском обвезнику/пореском плацу</i></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #c1c1c1;" class="border-1 border-black">1.1. ПИБ</td>
            <td colspan="2" style="background-color: #c1c1c1;" class="border-1 border-black">1.2. НАЗИВ</td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black">1.3. АДРЕСА ЦЕДИШТА</td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black">1.4. МЕСТО</td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black">1.5. ТЕЛЕФОН</td>
        </tr>
        <tr>
            <td colspan="2" class="border-1 border-black">{{ $klijent->pib }}</td>
            <td colspan="2" class="border-1 border-black">{{ $klijent->naziv }}</td>
            <td class="border-1 border-black">{{ $klijent->ulica }} {{ $klijent->broj_ulice }}</td>
            <td class="border-1 border-black">{{ $klijent->postanski_broj }} {{ $klijent->mesto }}</td>
            <td class="border-1 border-black">{{ $klijent->telefon }}</td>
        </tr>
        <tr>
            <td colspan="7"><i>2. подаци о законском заступанику</i></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #c1c1c1;" class=" border-1 border-black">2.1. ЈМБГ/ЕБЦ*</td>
            <td colspan="2" style="background-color: #c1c1c1;" class="border-1 border-black p-0 text-center">2.2. БРОЈ ПАЦОША<br>(само за нерезиденте)</td>
            <td colspan="2" style="background-color: #c1c1c1;" class="border-1 border-black text-center">2.3. ПРЕЗИМЕ И ИМЕ</td>
        </tr>
        <tr>
            <td colspan="2" class="border-1 border-black">{{ $odgovorno_lice->jmbg }}</td>
            <td colspan="2" class="border-1 border-black"></td>
            <td colspan="2" class="border-right border-1 border-black">{{ $odgovorno_lice->prezime }} {{ $odgovorno_lice->ime }}</td>
        </tr>
        <tr>
            <td colspan="7"><i>3. подаци о пореском пуномоћнику/лицу овлашћеном за употребу електронских цервиса</i></td>
        </tr>
        <tr>
            <td width="6%" style="background-color: #c1c1c1;" class="border-1 border-black">3.1. Р.Б.</td>
            <td width="14%" style="background-color: #c1c1c1;" class="border-1 border-black">3.2. ЈМБГ</td>
            <td width="20%" style="background-color: #c1c1c1;" class="border-1 border-black">3.3. ПРЕЗИМЕ И ИМЕ</td>
            <td width="15%" style="background-color: #c1c1c1;" class="border-1 border-black">3.4. ТЕЛЕФОН</td>
            <td width="20%" style="background-color: #c1c1c1;" class="border-1 border-black">3.5. ЕЛЕКТРОНСКА ПОШТА</td>
            <td width="12.5%" style="background-color: #c1c1c1;" class="border-1 border-black p-0">3.6. ДАТУМ ДОДЕЉИВАЊА</td>
            <td width="12.5%" style="background-color: #c1c1c1;" class="border-1 border-black p-0">3.7. ДАТУМ ПОВЛАЧЕЊА</td>
        </tr>
        <tr>
            <td class="border-1 border-black text-center">1</td>
            <td class="border-1 border-black">1610988773634</td>
            <td class="border-1 border-black">GLIŠIĆ SAŠA</td>
            <td class="border-1 border-black">069/284-9-382</td>
            <td class="border-1 border-black">office@akcize.rs</td>
            <td class="border-1 border-black">{{ date('d/m/Y') }}</td>
            <td class="border-1 border-black">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="7"><i>4. обим овлашћења за употребу електронских сервиса**</i></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #c1c1c1;" class="border-1 border-black p-0">
                <div class="row m-0 ms-1">
                    <div class="col-lg-10 p-0">4.1.<br>ЗА СВЕ ЕЛЕКТРОНСКЕ СЕРВИСЕ</div>
                    <div class="col pe-1 pt-1 text-end"><input class="mt-2" type="checkbox" checked></div>
                </div>                 
            </td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black p-0">
                <div class="row m-0 ms-1">
                    <div class="col-lg-10 p-0">4.2. ПИБ<br>&nbsp;</div>
                    <div class="col-lg-2 pe-1 pt-1 text-end"><input class="mt-2" type="checkbox"></div>
                </div>
            </td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black p-0">
                <div class="row m-0 ms-1">
                    <div class="col-lg-10 p-0">4.3. АКЦИЗЕ<br>&nbsp;</div>
                    <div class="col-lg-2 pe-1 pt-1 text-end"><input class="mt-2" type="checkbox"></div>
                </div>
            </td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black p-0">
                <div class="row m-0 ms-1">
                    <div class="col-lg-10 p-0">4.4. ПОРЕЗИ И ДОПРИНОСИ ПО ОДБИТКУ</div>
                    <div class="col-lg-2 pe-1 pt-1 text-end"><input class="mt-2" type="checkbox"></div>
            </td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black p-0">
                <div class="row m-0 ms-1">
                    <div class="col-lg-10 p-0">4.5. ДОБИТ<br>&nbsp;</div>
                    <div class="col-lg-2 pe-1 pt-1 text-end"><input class="mt-2" type="checkbox"></div>
                </div>
            </td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black p-0">
                <div class="row m-0 ms-1">
                    <div class="col-lg-10 p-0">4.6.<br>ФИСКЛИЗАЦИЈА</div>
                    <div class="col-lg-2 pe-1 pt-1 text-end"><input class="mt-2" type="checkbox"></div>
                </div>
            </td>
        </tr>
    </table>

    <table class="table table-borderless">
        <tr>
            <td width="20%" class="text-center">место и датум</td>
            <td width="45%">&nbsp;</td>
            <td style="" class="p-0 text-center">6. потпис пореског<br>обвезника/плаца/законског заступника</td>
        </tr>
        <tr>
            <td class=""><div class="border-1 border-1 border-black p-1 text-center">Loznica, {{ date('d.m.Y') }}</div></td>
            <td width="45%">&nbsp;</td>
            <td class="p-1 text-center border-1 border-1 border-black signature-container">
                <button type="button" class="btn btn-sm btn-secondary open-signiture-pad">Uneski Potpis</button>
            </td>
        </tr>
    </table>

    {!! Form::open(array('route' => 'pep.store','id' => 'pep-form','method'=>'POST')) !!}
    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
        <input type="hidden" name="clientId" value="{{$klijent->id}}">
        <button class="btn btn-outline-success make-pep" type="submit">Kreiraj PEP-Obrazac</button>
    {!! Form::close() !!}
    <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
<div class="modal fade signature-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Potpis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
          <canvas class="border-1 border" style="background-color:#f5efc7;" width="800" height="200"></canvas>
          <br>
          <button class="btn btn-sm btn-secondary reset-pad" type="button">Izbriši</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
        <button type="button" class="btn btn-primary save-signature">Preuzmi</button>
      </div>
    </div>
  </div>
</div>


@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif
@endsection
@section('pagescript')
<script>
    const canvas = document.querySelector("canvas");
    const signaturePad = new SignaturePad(canvas, {
        minWidth: 2,
        maxWidth: 5,
        penColor: "rgb(68, 45, 199)"
    });

    $('.save-signature').click(function(event) {

        var data = signaturePad.toDataURL();
        signaturePad.clear();
        $('.signature-container').html('<img class="open-signiture-pad" style="width:100%;" src="' + data + '">');
        $('.open-signiture-pad').html('Ponovi');
        $('.signature-modal').modal('hide');
    });

    $('.reset-pad').click(function(event) {

        signaturePad.clear();
    });

    $('body').on('click', '.open-signiture-pad', function(event){
        $('.signature-modal').modal('show');
    });

    $('#pep-form').submit(function(event) {
            event.preventDefault();

            
            var url = $(this).attr("action");
            var formData = $('body').find('.open-signiture-pad').attr('src');
            var clientId = $('input[name="clientId"]').val();

            if(typeof formData != 'undefined') {
                $('body').find('.overlay-loader').fadeIn();
                //console.log(url);
                //console.log(formData);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="csrf-token"]').val()
                    }
                });
                var request = $.ajax({
                    url: url,
                    method: 'POST',
                    data: {clientsig: formData, clientId: clientId},
                    dataType: 'json',
                    success: function(result){
                        window.location = "{{ env('APP_URL') }}/dokumenta/{{ $klijent->id }}";
                    }
                });
            } else {
                swal("Greška!", "Nije potpisano!", "error");
            }
            
        });
</script>
@stop