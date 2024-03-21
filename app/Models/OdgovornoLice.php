<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdgovornoLice extends Model
{
    use HasFactory;
    protected $table = "odgovorno_lice";
    protected $fillable = [
        'pol',
        'ime',
        'prezime',
        'telefon',
        'email',
    ];
}
