<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poreska_inspektor extends Model
{
    use HasFactory;
    protected $table = "poreska_inspektor";
    protected $fillable = [
        'pol',
        'ime',
        'prezime',
        'telefon',
        'email',
        'poreska_filijala_id ',
    ];
}
