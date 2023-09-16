<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fajlovi extends Model
{
    use HasFactory;
    protected $table = "fajlovi";
    protected $fillable = [
        'nalog_id',
        'tip',
        'fajl'
    ];
}
