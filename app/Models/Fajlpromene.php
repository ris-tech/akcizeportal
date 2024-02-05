<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fajlpromene extends Model
{
    use HasFactory;
    protected $table = "fajlpromene";
    protected $fillable = [
        'fajl',
        'aktivan'
    ];

}
