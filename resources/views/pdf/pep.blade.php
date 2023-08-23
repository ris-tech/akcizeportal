<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    
</head>
<body>
    <table class="table table-borderless" style="font-size:11pt;">
        <tr>
            <th colspan="5" class="border-2 border-black" style="background-color: #c1c1c1;">ОВЛАШЋЕЊЕ ЗА УПОТРЕБУ ЕЛЕКТРОНСКИХ СЕРВИСА</th>
            <th colspan="2" class="border-2 border-black" style="background-color: #c1c1c1;" >Образац ПЕП</th>
        </tr>
        <tr>
            <td colspan="7"><i>1. подаци о пореском обвезнику/пореском плацу</i></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #c1c1c1;" class="border-2 border-black">1.1. ПИБА</td>
            <td colspan="2" style="background-color: #c1c1c1;" class="border-2 border-black">1.2. НАЗИВ</td>
            <td style="background-color: #c1c1c1;" class="border-2 border-black">1.3. АДРЕСА ЦЕДИШТА</td>
            <td style="background-color: #c1c1c1;" class="border-2 border-black">1.4. МЕСТО</td>
            <td style="background-color: #c1c1c1;" class="border-2 border-black">1.5. ТЕЛЕФОН</td>
        </tr>
        <tr>
            <td colspan="2" class="border-2 border-black">{{ $klijent->pib }}</td>
            <td colspan="2" class="border-2 border-black">{{ $klijent->naziv }}</td>
            <td class="border-2 border-black">{{ $klijent->ulica }} {{ $klijent->broj_ulice }}</td>
            <td class="border-2 border-black">{{ $klijent->postanski_broj }} {{ $klijent->mesto }}</td>
            <td class="border-2 border-black">{{ $klijent->telefon }}</td>
        </tr>
        <tr>
            <td colspan="7"><i>2. подаци о законском заступанику</i></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #c1c1c1;" class=" border-2 border-black">2.1. ЈМБГ/ЕБЦ*</td>
            <td colspan="2" style="background-color: #c1c1c1;line-height:15pt;" class="border-2 border-black p-0 text-center">2.2. БРОЈ ПАЦОША<br>(само за нерезиденте)</td>
            <td colspan="2" style="background-color: #c1c1c1;" class="border-2 border-black text-center">2.3. ПРЕЗИМЕ И ИМЕ</td>
        </tr>
        <tr>
            <td colspan="2" class="border-2 border-black">{{ $odgovorno_lice->jmbg }}</td>
            <td colspan="2" class="border-2 border-black"></td>
            <td colspan="2" class="border-right border-2 border-black">{{ $odgovorno_lice->prezime }} {{ $odgovorno_lice->ime }}</td>
        </tr>
        <tr>
            <td colspan="7"><i>3. подаци о пореском пуномоћнику/лицу овлашћеном за употребу електронских цервиса</i></td>
        </tr>
        <tr>
            <td width="6%" style="background-color: #c1c1c1;" class="border-2 border-black">3.1. Р.Б.</td>
            <td width="14%" style="background-color: #c1c1c1;" class="border-2 border-black">3.2. ЈМБГ</td>
            <td width="20%" style="background-color: #c1c1c1;" class="border-2 border-black">3.3. ПРЕЗИМЕ И ИМЕ</td>
            <td width="15%" style="background-color: #c1c1c1;" class="border-2 border-black">3.4. ТЕЛЕФОН</td>
            <td width="20%" style="background-color: #c1c1c1;" class="border-2 border-black">3.5. ЕЛЕКТРОНСКА ПОШТА</td>
            <td width="12.5%" style="background-color: #c1c1c1;line-height:15pt;" class="border-2 border-black p-0">3.6. ДАТУМ ДОДЕЉИВАЊА</td>
            <td width="12.5%" style="background-color: #c1c1c1;line-height:15pt;" class="border-2 border-black p-0">3.7. ДАТУМ ПОВЛАЧЕЊА</td>
        </tr>
        <tr>
            <td class="border-2 border-black text-center">1</td>
            <td class="border-2 border-black">1610988773634</td>
            <td class="border-2 border-black">GLIŠIĆ SAŠA</td>
            <td class="border-2 border-black">069/284-9-382</td>
            <td class="border-2 border-black">office@akcize.rs</td>
            <td class="border-2 border-black">{{ date('d/m/Y') }}</td>
            <td class="border-2 border-black">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="7"><i>4. обим овлашћења за употребу електронских цервиса**</i></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #c1c1c1;line-height:15pt;" class="border-2 border-black p-0">
                <table>
                    <tr>
                        <td width="93.5%"> 4.1.<br>ЗА СВЕ ЕЛЕКТРОНСКЕ СЕРВИСЕ</td>
                        <td><input type="checkbox" checked></td>
                    </tr>
                </table>
            </td>
            <td style="background-color: #c1c1c1;" class="border-2 border-black">
                <table>
                    <tr>
                        <td width="93.5%">4.2. ПИБ</td>
                        <td><input type="checkbox"></td>
                    </tr>
                </table>
            </td>
            <td style="background-color: #c1c1c1;" class="border-2 border-black">
                <table>
                    <tr>
                        <td width="93.5%">4.3. АКЦИЗЕ</td>
                        <td><input type="checkbox"></td>
                    </tr>
                </table>
            </td>
            <td style="background-color: #c1c1c1;line-height:15pt;" class="border-2 border-black p-0">
                <table>
                    <tr>
                        <td width="91%">4.4. ПОРЕЗИ И ДОПРИНОСИ ПО ОДБИТКУ</td>
                        <td><input type="checkbox"></td>
                    </tr>
                </table>
            </td>
            <td style="background-color: #c1c1c1;" class="border-2 border-black">
                <table>
                    <tr>
                        <td width="93.5%">4.5. ДОБИТ</td>
                        <td><input type="checkbox"></td>
                    </tr>
                </table>
            </td>
            <td style="background-color: #c1c1c1;line-height:15pt;" class="border-2 border-black p-0">
                <table>
                    <tr>
                        <td width="89.5%">4.6.<br>ФИСКЛИЗАЦИЈА</td>
                        <td><input type="checkbox"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="table table-borderless">
        <tr>
            <td width="20%" class="text-center">место и датум</td>
            <td width="45%">&nbsp;</td>
            <td style="line-height:15pt;" class="p-0 text-center">6. потпис пореског<br>обвезника/плаца/законског заступника</td>
        </tr>
        <tr>
            <td class=""><span class="border border-2 border-black p-1">Loznica, {{ date('d.m.Y') }}</span></td>
            <td width="45%">&nbsp;</td>
            <td class="p-1 text-center border border-2 border-black signature-container">
                <img style="width:100%;" src="{{ asset('storage').'/'.$sigfile }}">
            </td>
        </tr>
    </table>
</body>