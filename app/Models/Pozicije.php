<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pozicije extends Model
{
    use HasFactory;
    protected $table = "pozicije";
    protected $fillable = [
        'nalog_id',
        'datum_fakture',
        'broj_fakture',
        'gorivo',
        'dobavljac_id',
        'iznos',
        'kolicina',
        'vozila'
    ];

    public function vozilo()
    {
      return $this->belongsTo(Vozila::Class,'vozila');
    }

    public function dobavljac()
    {
      return $this->belongsTo(Dobavljaci::Class,'dobavljac_id');
    }
}
