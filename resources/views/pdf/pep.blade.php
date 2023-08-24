<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    
    <style>
    @font-face {
	  font-family: 'Arial';
	  font-style: normal;
	  font-weight: normal;
	  src: url("../storage/fonts/Arial.ttf") format('truetype');
	}
    html { 
        margin: 3.5cm 2.5cm 1.5cm 1.5cm;
        letter-spacing:-0.4px;
        line-height:10pt;
        font-family: 'Arial';
        font-weight: 400;
    }
    @page { margin: 3.5cm 2.5cm 1.5cm 1.5cm; }
    td, th {
        padding-top:6px;padding-bottom:6px;
        font-family: 'Arial';
    }
    tr {
        font-family: 'Arial';
    }
    </style>
</head>
<body>
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
            <td style="background-color: #c1c1c1;" class="border-1 border-black">1.3. АДРЕСА СЕДИШТА</td>
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
            <td colspan="2" style="background-color: #c1c1c1;" class=" border-1 border-black">2.1. ЈМБГ/ЕБС*</td>
            <td colspan="2" style="background-color: #c1c1c1;" class="border-1 border-black p-0 text-center">2.2. БРОЈ ПАСОША<br>(само за нерезиденте)</td>
            <td colspan="2" style="background-color: #c1c1c1; border-right: solid;" class="border-1 border-black text-center">2.3. ПРЕЗИМЕ И ИМЕ</td>
            <td style="background-color: #ffffff; border-left: solid;" class="border-start border-black text-center">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" class="border-1 border-black">{{ $odgovorno_lice->jmbg }}</td>
            <td colspan="2" class="border-1 border-black"></td>
            <td colspan="2" class="border-right border-1 border-black" style="border-right: solid;">{{ $odgovorno_lice->prezime }} {{ $odgovorno_lice->ime }}</td>
            <td style="background-color: #ffffff; border-left: solid;" class="border-start border-black text-center">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="7"><i>3. подаци о пореском пуномоћнику/лицу овлашћеном за употребу електронских сервиса</i></td>
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
                    <div class="col text-end"><input type="checkbox" checked style="margin-top:-30px;margin-right:15px;"></div>
                </div>                 
            </td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black p-0">
                <div class="row m-0 ms-1">
                    <div class="col-lg-10 p-0">4.2. ПДВ<br>&nbsp;</div>
                    <div class="col-lg-2 text-end"><input type="checkbox" style="margin-top:-30px;margin-right:15px;"></div>
                </div>
            </td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black p-0">
                <div class="row m-0 ms-1">
                    <div class="col-lg-10 p-0">4.3. АКЦИЗЕ<br>&nbsp;</div>
                    <div class="col-lg-2 text-end"><input type="checkbox" style="margin-top:-30px;margin-right:15px;"></div>
                </div>
            </td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black p-0">
                <div class="row m-0 ms-1">
                    <div class="col-lg-10 p-0">4.4. ПОРЕЗИ И ДОПРИНОСИ ПО ОДБИТКУ</div>
                    <div class="col-lg-2 text-end"><input type="checkbox" style="margin-top:-30px;margin-right:15px;"></div>
            </td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black p-0">
                <div class="row m-0 ms-1">
                    <div class="col-lg-10 p-0">4.5. ДОБИТ<br>&nbsp;</div>
                    <div class="col-lg-2 text-end"><input type="checkbox" style="margin-top:-30px;margin-right:15px;"></div>
                </div>
            </td>
            <td style="background-color: #c1c1c1;" class="border-1 border-black p-0">
                <div class="row m-0 ms-1">
                    <div class="col-lg-10 p-0">4.6.<br>ФИСКЛИЗАЦИЈА</div>
                    <div class="col-lg-2 text-end"><input type="checkbox" style="margin-top:-30px;margin-right:15px;"></div>
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
            <td class="text-center">Loznica, {{ date('d.m.Y') }}</td>
            <td width="45%">&nbsp;</td>
            <td class="p-1 text-center signature-container">
                <img style="width:100%;" src="{{ asset('storage').'/'.$sigfile }}">
            </td>
        </tr>
    </table>
    <span style="font-size:8pt;">* Јединствени матични број грађана/евиденциони број странца - нерезидента<br>
    ** Заокружити изабрани електронски сервис</span>
</body>