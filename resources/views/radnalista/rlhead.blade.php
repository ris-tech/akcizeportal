<div class="row">
    <div class="col-md-2">
        <div class="card">
            <div class="card-body bg-secondary text-light">
                <strong>Klijent</strong>
                <h5>{{$nalozi->klijent['naziv']}}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body bg-secondary text-light">
                <strong>Godina</strong>
                <h5>{{$nalozi->kvartal['godina']}}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body bg-secondary text-light">
                <strong>Kvartal</strong>
                <h5>{{$nalozi->kvartal['kvartal']}}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body bg-secondary text-light">
                <strong>Od</strong>
                <h5>{{date('d.m', strtotime($nalozi->kvartal['od']))}}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body bg-secondary text-light">
                <strong>Do</strong>
                <h5>{{date('d.m', strtotime($nalozi->kvartal['do']))}}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body bg-secondary text-light">
                FILIJALA {{ $poreska_filijala->ime }}
                PIB: {{ $nalozi->klijent['pib'] }}
            </div>
        </div>
    </div>
</div>