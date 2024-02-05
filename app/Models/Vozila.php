<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vozila extends Model
{
    use HasFactory;
    protected $table = "vozila";
    protected $fillable = [
        'klijent_id',
        'reg_broj',
        'licenca',
        'od',
        'do',
        'saobracajna',
        'saobracajna_od',
        'saobracajna_do',
        'broj_sasije'
    ];
}
