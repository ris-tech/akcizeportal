@extends('layouts.app')

@section('content')
<div class="row justify-content-between mb-5">
    <div class="col-lg-3">
        <h2>Ugovor</h2>
    </div>
</div>
@if($ugovor_file != '') 
  <a href="http://localhost/{{ $ugovor_path }}{{ $ugovor_file }}">Ugovor</a>
  @else
  <div class="ugovor-form">
    <page size="A4">
      <span class="paragraph"></span>У смислу одредби Закона о облигационим односима  („Сл.лист СФРЈ“, бр.29/78, 39/85 –
      одлука УСЈ и 57/89, „СЛ.лист СРЈ“, бр.31/93, „СЛ.лист СЦГ“, бр.1/2003 – Уставна повеља и
      „СЛ.гласник РС“, бр. 18/2020) дана 28.04.2023.године закључује се  : 
      <br>
      <br>
      <div class="ugovor-title ugovor-center">У Г О В О Р</div>
      <div class="ugovor-center">пословној сарадњи</div><br><br>
      између:<br><br>
      <span class="paragraph2">-</span><b>SAŠA GLIŠIĆ PR USLUGE PODRŠKE POSLOVANJU</b>, Лозница ул. Драгојла Дудића бр.8,<br>
      <span class="paragraph"></span>ПИБ:111167318 кога заступа директор Саша Глишић  у даљем тексту <b>извршилац посла</b>,  и 
      <br><br>
      <span class="paragraph2">-</span><b>{{$klijent->naziv}}</b> ,{{$klijent->postanski_broj}} {{$klijent->mesto}} {{$klijent->ulica}} бр. {{$klijent->broj_ulice}}, ПИБ:{{$klijent->pib}} кога заступа директор<br>
      <span class="paragraph"></span>{{$odgovorno_lice->ime}} {{$odgovorno_lice->prezime}}  у даљем тексту <b>наручилац посла</b>.<br><br><br>
      <div class="ugovor-center"><b>Члан 1.</b></div><br>
      <span class="paragraph"></span>Овим уговором стране слободно, у границама принудних прописа, јавног поретка и добрих обичаја уређују своје односе  по својој вољи.<br>
      <span class="paragraph"></span>Предмет овог уговора је пословна сарадња уговорених страна у остваривању права на рефакцију плаћене акцизе на деривате нафте, биогорива и биотечности из члана 9. став 1. тач. 3), 5) и 7) Закона о акцизама, које у  транспортне сврхе користи наручилац посла.  
      <br><br>
      <div class="ugovor-center"><b>Члан 2.</b></div><br>
      <span class="paragraph"></span>Наручилац посла се обавезује да ће истог дана по закључењу овог уговора у писаном облику дати пуномоћје извршиоцу посла  да га заступа у поступку за остваривање права на рефакцију плаћене акцизе на деривате нафте пред надлежном организационом јединицом Пореске управе  према свом седишту.
      <br><br>
      <div class="ugovor-center"><b>Члан 3.</b></div><br>
      <span class="paragraph"></span>Наручилац посла се обавезује да ће по истеку квартала, односно након потписивања овог уговора, а најкасније протеком 5 дана  доставити извршиоцу посла све доказе који су прописани чл.8 ст.3 Правилника о ближим условима, начину и поступку за остваривање права на рефакцију плаћене акцизе на деривате нафте, биогорива и биотечности из члана 9. став 1. тач. 3), 5) и 7) Закона о акцизама, који се користе за транспортне сврхе и за грејање, а које је неопходно да  извршилац посла  приложи уз Захтев за рефакцију плаћене акцизе на деривате нафте, односно биогорива из члана 9. став 1. тач. 3), 5) и 7) Закона о акцизама.
      <br>
      <span class="paragraph"></span>Наручилац посла  одговоран је у смислу кривичног законодавства Републике Србије за веродостојност приложених доказа ивршиоцу посла из става 1 овог члана односно да све доказе које је доставио извршиоцу посла нису лажни или преиначени. 
    </page>
    <page size="A4">
      <div class="ugovor-center"><b>Члан 4.</b></div><br>
      <span class="paragraph"></span>Извршилац посла се обавезује да ће надлежној организационом јединицом Пореске управе   накасније до истека  текућег квартала поднети писмени Захтев за рефакцију плаћене акцизе на деривате нафте, односно биогорива из члана 9. став 1. тач. 3), 5) и 7) Закона о акцизама за претходни квартал на  обрасцу РЕФ-Т са прилогом доказа из члана 3 овог уговора које му је доставио наручилац посла. 
      <br><br>
      <div class="ugovor-center"><b>Члан 5.</b></div><br>
      <span class="paragraph"></span>Уговорене стране су се споразумеле да након што се изврши рефакција акцизе према донетом решењу надлежне организационе јединице Пореске управе, односно _ филијала Лозница, а најкасније 3 (три) дана од враћања акцизе извршилац посла достави наручиоцу фактуру на   20  % за заступања у посутпку и предузимање процесних радњи за његово име и за његов рачун, од плаћене-враћене акцизе на деривате нафте коришћене у транспортне сврхе а по основу решења надлежне организационе јединице Пореске управе достављеног надлежној организационој јединици Управе за трезор.<br>
      <span class="paragraph"></span>Наручилац посла се обавезује да ће по достављању фактуре извршиоца посла из става 1 овог члана уплатити износ од <b>{{$klijent->cena}} %</b> према донетом решењу надлежне организационе јединице Пореске управе на текући рачун извршиоца посла бр.<b>{{$klijent->broj_bankovog_racuna}} {{$banka->ime}}</b> најкасније у року од 3 (три) дана по достављању фактуре. <br>
      <span class="paragraph"></span>Уколико наручилац посла задоцњи са испуњењем новчане обавезе из става 1 и 2 овог члана поред главнице, дугује и затезну камату на износ дуга до дана исплате, и то по стопи утврђеној Законом о затезној камати.
      <br><br>
      <div class="ugovor-center"><b>Члан 6.</b></div><br>
      <span class="paragraph"></span>Уговорене стране се обавезују да штите пословне тајне, односно информације које нису у целини или у погледу структуре и скупа њихових саставних делова опште познате или лако доступне лицима која у оквиру својих активнсоти уобичајено долазе у контакт са таквом врстом инфомација и које имају комерцијалну вредност, друге стране од незаконитог прибављања, коришћења и откривања. 
      <br><br>
      <div class="ugovor-center"><b>Члан 7.</b></div><br>
      <span class="paragraph"></span>Уговор се закључује на неодређено време.<br>
      <span class="paragraph"></span>Уколико једна уговорена страна не испуни своју обавезу, друга страна може захтевати испуњење обавеза или у складу са законом раскинути уговор простом изјавом а у сваком случају има право на накнаду штете.  <br>
      <span class="paragraph"></span>Уговорена страна која због не испуњених обавеза друге стране раскида уговор дужна је то саопштити другој страни без одлагања писаним путем. <br>
      <span class="paragraph"></span>Уговор се може раскинути споразумом уговорених страна или једнсотрано уз остављање отказног рока који не може бити у текућем кварталу.<br>
      <span class="paragraph"></span>Споразум о раскиду уговора и једнострани отказ уговора морају бити сачињени у писаној форми.<br>
      <span class="paragraph"></span>У слчају раскида уговора наручилац посла је дужан да извршиоцу посла исплати новчану надокнаду обрачунату за одговарајући део испуњења уговорених обавеза до момента раскида као и новчану надоканду на име потрошног материјала. <br>
    </page>
    <page size="A4">
      <div class="ugovor-center"><b>Члан 8.</b></div><br>
      <span class="paragraph"></span>Измене и допуне овог уговора могу се вршити само писменим путем уз сагласност обеју уговорених страна закључењем анекса уговора.
      <br><br>
      <div class="ugovor-center"><b>Члан 9.</b></div><br>
      <span class="paragraph"></span>На сва питања која нису регулисана овим Уговором примењиваће се одредбе важећих закона Републике Србије а пре свега одредбе Закона о облигационим односима. <br>
      <span class="paragraph"></span>Уколико дође до спора по овом уговору, странке ће исти решити споразумно и у поступку медијације, у супротном спор ће се решити пред месно надлежним судом односно Основним судом у Лозници.
      <br><br>
      <div class="ugovor-center"><b>Члан 10.</b></div><br>
      <span class="paragraph"></span>Овај уговор састављен је у 4 (четири) истоветна примерка од којих свака страна задржава по два примерка.
      <br><br>
      <div class="ugovor-center"><b>Члан 11.</b></div><br>
      <span class="paragraph"></span>Овај уговор ступа на снагу {{date('d.m.Y')}}.године.<br><br><br>
      <span class="paragraph"></span>У Лозници, {{date('d.m.Y')}}.године<br><br><br>
      <table width="100%">
        <tr>
          <td width="50%" style="text-align: center;">
            извршилац посла:
          </td>
          <td width="50%" style="text-align: center;">
            наручилац посла:
          </td>
        </tr>
        <tr>
          <td width="50%" style="text-align: center;">
            <img style="width:60%;" src="{{ asset('storage/ksk74u4ijs9IJge8Jjeh-hdjsjese974hjskjr774hs.png') }}">
          </td>
          <td width="50%" style="text-align: center;" class="signature-container">
            <button type="button" class="btn btn-secondary open-signiture-pad">Uneski Potpis</button>
          </td>
        </tr>
        <tr>
          <td width="50%" style="text-align: center;">
            <b>директор Саша Глишић</b>
          </td>
          <td width="50%" style="text-align: center;">
            <b>директор {{$odgovorno_lice->ime}} {{$odgovorno_lice->prezime}}</b>
          </td>
        </tr>
      </table>
    </page>
  </div>
@endif
  {!! Form::open(array('route' => 'ugovor.store','id' => 'ugovor-form','method'=>'POST')) !!}
  <input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
    <input type="hidden" name="clientId" value="{{$klijent->id}}">
    <button class="btn btn-outline-success make-contract" type="submit">Kreiraj ugovor</button>
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
          <canvas class="border border-2" style="background-color:#f5efc7;" width="800" height="200"></canvas>
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