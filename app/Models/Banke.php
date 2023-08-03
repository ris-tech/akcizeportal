<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banke extends Model
{
    use HasFactory;
    protected $table = "banke";
    protected $fillable = [
        'ime'
    ];
}
