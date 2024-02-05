<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class izvestaj_po_vozilu extends Model
{
    use HasFactory;
    protected $table = "izvestaj_po_vozilu";
    protected $fillable = [
        'nalog_id',
        'vozilo_id',
        'predjene_km'
    ];
}
