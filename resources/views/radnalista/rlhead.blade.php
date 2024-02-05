<div class="row">
    <div class="col">
        <div class="card" style="height:90px;">
            <div class="card-body bg-secondary text-light">
                <strong>Naziv firme</strong>
                <h5>{{$nalozi->klijent['naziv']}}</h5>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card" style="height:90px;">
            <div class="card-body bg-secondary text-light">
                <strong>Kvartal</strong>
                <h5>{{$nalozi->kvartal['kvartal']}}</h5>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card" style="height:90px;">
            <div class="card-body bg-secondary text-light">
                <strong>Od</strong>
                <h5>{{date('d.m.Y', strtotime($nalozi->kvartal['od']))}}</h5>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card" style="height:90px;">
            <div class="card-body bg-secondary text-light">
                <strong>Do</strong>
                <h5>{{date('d.m.Y', strtotime($nalozi->kvartal['do']))}}</h5>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card" style="height:90px;">
            <div class="card-body bg-secondary text-light">
                <b>FILIJALA:</b> {{ $poreska_filijala->ime }}<br>
                <b>PIB:</b> {{ $nalozi->klijent['pib'] }}
            </div>
        </div>
    </div>
</div>