<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NVIznosi extends Model
{
    use HasFactory;
    protected $table = "nv_iznosi";
    protected $fillable = [
        'nalog_id',
        'br_fakture',
        'kupljeno'
    ];
}
