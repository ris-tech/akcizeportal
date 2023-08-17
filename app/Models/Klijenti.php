<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klijenti extends Model
{
    use HasFactory;
    protected $table = "klijenti";
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
        'knjigovodja_id',
        'poreska_filijala_id',
        'banka_id',
        'broj_bankovog_racuna',
        'cena',
        'pep_obrazac',
        'prioritet',
    ];
}
