<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kvartali extends Model
{
    use HasFactory;
    protected $table = "kvartali";
    protected $fillable = [
        'godina',
        'kvartal',
        'od',
        'do'
    ];
}
