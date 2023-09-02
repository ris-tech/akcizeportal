<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dobavljaci extends Model
{
    use HasFactory;
    protected $table = "dobavljaci";
    protected $fillable = [
        'ime'
    ];
}
