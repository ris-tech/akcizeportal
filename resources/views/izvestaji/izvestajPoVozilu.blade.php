@extends('layouts.app')

@section('content')
{!! Form::open(array('route' => 'izvestaji.sacuvajIzvestajPoVozilu','id' => 'finish-izvestaj-form','method'=>'POST')) !!}
<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
<input type="hidden" name="nalog_id" value="{{$nalozi->id}}">
<div class="row">
    <div class="col-md-6">
        <h1>Izveštaji po vozilu</h1>
    </div>
    <div class="col-md-6 text-end">
        <button class="btn btn-outline-success finish-unos" type="submit">Sačuvaj</button>
        <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPoDobavljacu" aria-controls="offcanvasPoDobavljacu">
            Po dobavljaču
        </button>
        <a href="{{ route('radnalista.tabela', $nalozi->id) }}" class="btn btn-outline-dark" target="_blank">Tabela utrošak</a>
    </div>
</div>

<div class='context-menu'>
    <div class="list-group">
        <a href="" class="list-group-item list-group-item-action cm-tabela" target="_blank"><i class="fa-solid fa-table"></i> Tabela utrošak</a>
        <a href="{{ route('vozila.show', $nalozi->klijent_id) }}" class="list-group-item list-group-item-action cm-vozilo" target="_blank"><i class="fa-solid fa-car-side"></i> Izmeni vozilo</a>
    </div>
</div>

<div class='context-menu-dobavljac'>
    <div class="list-group">
        <a href="" class="list-group-item list-group-item-action cmd-tabela" target="_blank"><i class="fa-solid fa-table"></i> Tabela utrošak</a>
        <a href="" class="list-group-item list-group-item-action cmd-dobavljac" target="_blank"><i class="fa-solid fa-oil-well"></i> Izmeni dobavljača</a>
    </div>
</div>

<!--      OFFCANVAS PO DOBAVLJACU      -->

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasPoDobavljacu" aria-labelledby="offcanvasPoDobavljacuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasPoDobavljacuLabel">Izveštaj po dobavljaču</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="container">
            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                            <tr class="table-secondary">
                                <th>Pos</th>
                                <th>Dobavljač</th>
                                <th>Iznos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dobavljaciPoNalogu as $dobavljac)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dobavljac->dobavljac->ime }}</td>
                                    <td>RSD {{ number_format($dobavljac->sum_iznos,2,',','.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="border-top border-2 border-black border-bottom-0 border-start-0 border-end-0 fw-bold">
                                <td>Upukno</td>
                                <td>&nbsp;</td>
                                <td>RSD {{ number_format($iznosUkupno->sum_iznos,2,',','.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
    <div class="col-md-12">
        <table class="table table-sm table-striped izvestaj">
            <thead>
                <tr>
                    <th class="noCalc" width="2%">Br.</th>
                    <th class="noCalc"  width="9%">REG. VOZILA</th>
                    @foreach ($dobavljaciPoNalogu as $dobavljacPoNalogu)
                        <th addon="R" addonVal="L" class="dobavljacId" id="{{$dobavljacPoNalogu->dobavljac->id}}">KOLIČINA<br>{{ $dobavljacPoNalogu->dobavljac->ime }}</th>
                    @endforeach 
                    <th addon="R" addonVal="L" width="8%">UKUPNO LITARA</th>
                    <th addon="R" addonVal="KM" width="13%">PREĐENO KM</th>
                    <th class="noCalc" width="7%">PROSEČNA POTROŠNJA</th>
                </tr>

            </thead>
            <tbody>
                @foreach ($vozilaPoNalogu as $voziloPoNalogu)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <input type="hidden" name="vozilo[]" value="{{$voziloPoNalogu->vozila}}">
                        @if($voziloPoNalogu->vozilo->do >= date('Y-m-d') && $voziloPoNalogu->vozilo->saobracajna_do >= date('Y-m-d')) <i class="fa-regular fa-circle-check text-success"></i> @else @if($voziloPoNalogu->vozilo->od != NULL && $voziloPoNalogu->vozilo->saobracajna_od != NULL) <i class="fa-solid fa-triangle-exclamation text-warning"></i> @else <i class="fa-regular fa-circle-xmark text-danger"></i>  @endif @endif<span class="reg_broj" id="{{$voziloPoNalogu->vozila}}">{{$voziloPoNalogu->vozilo->reg_broj}}</span>
                    </td>
                    @foreach ($dobavljaciPoNalogu as $dobavljacPoNalogu)
                        @if(array_key_exists($dobavljacPoNalogu->dobavljac_id, $dobavljaciPoVozilu[$voziloPoNalogu->vozila]))
                            <td id="{{$dobavljacPoNalogu->dobavljac_id}}">{{ number_format($dobavljaciPoVozilu[$voziloPoNalogu->vozila][$dobavljacPoNalogu->dobavljac_id], 2, ',', '.') }} L</td>
                        @else
                            <td>0,00 L</td>
                        @endif
                    @endforeach
                    <td>
                        <span class="litara">{{number_format($voziloPoNalogu->sum_kolicina, 2, ',', '.')}}</span> L
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" name="km[]" class="form-control calc" placeholder="KM" aria-describedby="basic-addon2" value="{{$voziloPoNalogu->predjene_km}}" required>
                            <span class="input-group-text" id="basic-addon2">KM</span>
                        </div>
                    </td>
                    <td class="potrosnja">
                    </td>
                </tr>  
                @endforeach  
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-bg-secondary fw-bold">Total</td>
                    <td class="text-bg-secondary fw-bold">&nbsp;</td>
                    @foreach ($dobavljaciPoNalogu as $dobavljacPoNalogu)
                        <td class="text-bg-secondary fw-bold">0,00 L</td>
                    @endforeach
                    <td class="text-bg-secondary fw-bold suma_litara">0,00 L</td>
                    <td class="text-bg-secondary fw-bold suma_km"></td>
                    <td class="text-bg-secondary fw-bold suma_potrosnje"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<h3>Vozila i količine koje ne ispunjavaju uslove</h3>
<div class="row">
    <div class="col-md-7">
        <table class="table table-sm table-striped table-reft">
            <thead>
            <tr>
                <th>Datum Fakture</th>
                <th>Broj Fakture</th>
                <th>Količina</th>
                <th>Napomena</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reft->groupBy('reg_broj') as $vozilo => $reftpozicije)
                <tr>
                    <td colspan="4" class="text-bg-secondary">{{ $vozilo }}</td>
                </tr>
                @foreach($reftpozicije as $reftpozicija)
                    <tr>
                        <td>{{ Str::cleanDate($reftpozicija->datum_fakture) }}</td>
                        <td>{{ $reftpozicija->broj_fakture }}</td>
                        <td><span class="reft-kolicina">{{ number_format($reftpozicija->kolicina, 2, ',', '.') }}</span> L</td>
                        <td>Licenca važeća<br>od <b>{{ Str::cleanDate($reftpozicija->od) }}</b> do <b>{{ Str::cleanDate($reftpozicija->do) }}</b></td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-bg-secondary fw-bold" colspan="2">Total</td>
                    <td colspan="2" class="text-bg-secondary fw-bold total-reft"></td>
                </tr>   
            </tfoot>
        </table>
    </div>
    <div class="col-md-5">
        <table class="table table-sm">
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th class="text-bg-dark">REF-T</th>
                <th class="text-bg-dark reft-kolicina-suma">jj</th>
                <th class="text-bg-dark reft-km-suma">jj</th>
                <th class="text-bg-dark prosek-potrosnje"></th>
            </tr>
        </table>
    </div>
</div>
{!! Form::close() !!}
@section('pagescript')
    <script type="text/javascript">
    var sumaReftkolicine = 0.00;
    $(document).ready(function(){
        
        $('.reft-kolicina').each(function() {
            var reftkolicina = $(this);
            var reftkolicinaClean = parseFloat($(reftkolicina).text().replace('.','').replace(',','.'));
            sumaReftkolicine = sumaReftkolicine+reftkolicinaClean;
            
        });
        $('.total-reft').html($.number(sumaReftkolicine,2,',','.') +' L');

        // disable right click and show custom context menu
        $(".reg_broj").bind('contextmenu', function (e) {
            var voziloId = $(this).attr('id');
            var baseurl =  "{{ route('radnalista.tabela', ['id' => $nalozi->id, 'tip' => 'poVozilu']) }}";
            var url = baseurl+'/'+voziloId; 
            this.href = url;
            $('.cm-tabela').prop("href", url);
            $('.cm-vozilo').attr('id', voziloId);
            var top = e.pageY+5;
            var left = e.pageX;

            // Show contextmenu
            $(".context-menu").toggle(100).css({
                top: top + "px",
                left: left + "px"
            });

            // disable default context menu
            return false;
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

        // disable context-menu from custom menu
        $('.context-menu').bind('contextmenu',function(){
            return false;
        });

        $('.context-menu-dobavljac').bind('contextmenu',function(){
            return false;
        });

        // Clicked context-menu item
        $('.context-menu .cm-tabela').click(function(){
            $(".context-menu").hide();
        });

        $('.context-menu .cmd-tabela').click(function(){
            $(".context-menu-dobavljac").hide();
        });

        $('.cm-vozilo').click(function(){
            swal({
                title: "Paznja",
                text: "Sačuvaj izveštaj za novu proveru vozila",
                icon: "warning",
                type: "warning",
                showConfirmButton:false,
                confirmButtonText: 'Yes, delete it!'
            });
            $(".context-menu").hide();
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

        $('input[name="km[]"]').each(function() {
            var parent = $(this).parent().parent().parent();
            var crrValue = $(this).val();
            if(crrValue != '') {
                var litara = parseFloat($(parent).find('.litara').text().replace('.','').replace(',','.'));
                console.log(litara);
                var calcVal = parseFloat(crrValue.replace('.','').replace(',','.'));
                console.log(calcVal);
                var calcPoKilometru = litara / calcVal;
                console.log($.number(calcPoKilometru,2,',','.'));
                parent.find('.potrosnja').html($.number(calcPoKilometru,2,',','.')+' L/km');
            }   
        });
        $('input[name="km[]"]').keyup(function() {
            this.value = this.value.replace(/\D/g, '');
        });
        $('input[name="km[]"]').focusout(function() {
            let parent = $(this).parent().parent().parent();
            let kolicina = $(this).val();
            if(kolicina == '') {
                parent.find('.potrosnja').html('');
            } else {
                let clean_kolicina = parseFloat(kolicina.replace(',','.'));
                let find_litara = parent.find('.litara').html();
                console.log(find_litara);
                let litara = parseFloat(find_litara.replace('.','').replace(',','.'));
                let calc_kol_litara = litara/clean_kolicina;
                let potrosnja = parent.find('.potrosnja').html($.number(calc_kol_litara.toFixed(2),2,',','.')+' L/km');
            }
            recalcColumn();
        });

        $(document).ready(function () {
            recalcColumn();
        });

        function recalcColumn() {
            $('.izvestaj thead th').each(function (i) {
                if($(this).hasClass('noCalc')) {

                } else {
                    calculateColumn(i, $(this).attr('addon'), $(this).attr('addonVal'));
                }
            });
        }
        function calculateColumn(index, addon, addonVal) {
            var total = 0;
            $('.izvestaj tbody tr').each(function () {
                findInput = $('td', this).eq(index).find('input');
                if (findInput.length == 1) {
                    var crrVal = $(findInput).val();
                } else {
                    var crrVal = $('td', this).eq(index).text().replace('.','').replace(',','.').replace('RSD ','').replace(' L','').replace(' L/km','');
                }
                var value = parseFloat(crrVal);
                
                if (!isNaN(value)) {
                    total += value;
                }
            });
            if (addon == 'L') {
                $('table tfoot td').eq(index).html(addonVal + ' ' + $.number(total,2,',','.'));
            } else {
                $('table tfoot td').eq(index).html($.number(total,2,',','.') + ' ' + addonVal);
            }
            var suma_litara = $('.suma_litara').text().replace('.','').replace(',','.').replace(' L','');
            var suma_km = $('.suma_km').text().replace('.','').replace(',','.').replace(' KM','');
            var suma_litara_clean = parseFloat(suma_litara);
            var suma_km_clean = parseFloat(suma_km);
            var suma_potrosnje = suma_litara_clean/suma_km_clean;
            $('.suma_potrosnje').html($.number(suma_potrosnje,2,',','.') + ' L/km');

            var odbijina_kolicina_suma = suma_litara_clean-sumaReftkolicine;
            var reft_km_suma = odbijina_kolicina_suma/suma_potrosnje;

            $('.prosek-potrosnje').html($.number(suma_potrosnje,2,',','.') + ' L/km');
            $('.reft-kolicina-suma').html($.number(odbijina_kolicina_suma,2,',','.') + ' L');
            $('.reft-km-suma').html($.number(reft_km_suma,0,',','.') + ' KM');

        }

        
    </script>
@stop
@endsection