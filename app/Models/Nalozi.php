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
        'evrodizel',
        'tng',
        'taxi',
        'skener_ulazne_fakture_id',
        'skener_izlazne_fakture_id',
        'skener_izvodi_id',
        'skener_kompenzacije_id',
        'skener_knjizna_odobrenja_id',
        'sken_ulazne_fakture',
        'sken_izlazne_fakture',
        'sken_izvodi',
        'sken_kompenzacije',
        'sken_knjizna_odobrenja',
        'unosilac_id',
        'unos_gotov',
        'izvestaj_o_placanju_gotov'
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
