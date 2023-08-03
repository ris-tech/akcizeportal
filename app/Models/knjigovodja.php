<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class knjigovodja extends Model
{
    use HasFactory;
    protected $table = "knjigovodja";
    protected $fillable = [
        'naziv',
        'ulica',
        'broj_ulice',
        'postanski_broj',
        'mesto',
        'telefon',
        'email',
    ];
}
