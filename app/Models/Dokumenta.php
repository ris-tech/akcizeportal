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
        'tip',
        'fajl',
        'datum_fajla'
    ];
}
