<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nalozi extends Model
{
    use HasFactory;
    protected $table = "nalozi";
    protected $fillable = [
        'klijent_id',
        'kvartal_id',
        'gorivo_id',
        'skener_ulazne_fakture_id',
        'skener_izlazne_fakture_id',
        'skener_izvodi_id',
        'skener_analiticke_kartice_id',
        'skener_licenca_id',
        'skener_saobracajna_id',
        'skener_depo_karton_id',
        'skener_kompenzacije_id',
        'skener_knjizna_odobrenja_id',
        'unosilac_id'
    ];
    
    public function klijent()
    {
      return $this->belongsTo(Klijenti::Class,'klijent_id');
    }

    public function unosilac()
    {
      return $this->belongsTo(User::Class,'unosilac_id');
    }
    public function skener_ulazne_fakture() { return $this->belongsTo(User::Class,'skener_ulazne_fakture_id'); }
    public function skener_izlazne_fakture() { return $this->belongsTo(User::Class,'skener_izlazne_fakture_id'); }
    public function skener_izvodi() { return $this->belongsTo(User::Class,'skener_izvodi_id'); }
    public function skener_analiticke_kartice() { return $this->belongsTo(User::Class,'skener_analiticke_kartice_id'); }
    public function skener_licenca() { return $this->belongsTo(User::Class,'skener_licenca_id'); }
    public function skener_saobracajna() { return $this->belongsTo(User::Class,'skener_saobracajna_id'); }
    public function skener_depo_karton() { return $this->belongsTo(User::Class,'skener_depo_karton_id'); }
    public function skener_kompenzacije() { return $this->belongsTo(User::Class,'skener_kompenzacije_id'); }
    public function skener_knjizna_odobrenja() { return $this->belongsTo(User::Class,'skener_knjizna_odobrenja_id'); }

    public function kvartal()
    {
      return $this->belongsTo(Kvartali::Class,'kvartal_id');
    }
    public function gorivo()
    {
      return $this->belongsTo(Gorivo::Class,'gorivo_id');
    }
}
