<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumenta extends Model
{
    use HasFactory;
    protected $table = "klijenti_dokumenta";
    protected $fillable = [
        'klijent_id',
        'ugovor',
        'broj_ugovora',
        'datum_ugovora',
        'pep'
    ];
}
