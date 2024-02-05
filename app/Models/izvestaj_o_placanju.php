<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class izvestaj_o_placanju extends Model
{
    use HasFactory;
    protected $table = "izvestaj_o_placanju";
    protected $fillable = [
        'nalog_id',
        'broj',
        'datum',
        'banka_id',
        'iznos',
        'napomena',
        'vezni_dokument'
    ];
}
