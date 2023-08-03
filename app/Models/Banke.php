<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banke extends Model
{
    use HasFactory;
    protected $table = "Banke";
    protected $fillable = [
        'ime'
    ];
}
