<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poreska_filijala extends Model
{
    use HasFactory;
    protected $table = "poreska_filijala";
    protected $fillable = [
        'ime',
        'ulica',
        'broj_ulice',
        'postanski_broj',
        'mesto',
    ];
}
