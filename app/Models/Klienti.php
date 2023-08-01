<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klienti extends Model
{
    use HasFactory;
    protected $table = "klienti";
    protected $fillable = [
        'naziv',
        'pib',
        'maticni_broj',
        'ulica',
        'broj_ulice',
        'postanski_broj',
        'mesto',
        'opstina',
        'odgovorno_lice_id',
        'broj_ugovora',
        'datum_ugovora',
        'pocetak_obrade',
        'poreska_filijala_id',
        'banka_id',
        'broj_bankovog_racuna',
        'cena',
        'pep_obrazac',
        'prioritet',
    ];
}
