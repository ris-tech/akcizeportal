<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saobracajne extends Model
{
    use HasFactory;
    protected $table = "saobracajne";
    protected $fillable = [
        'vozilo_id',
        'od',
        'do',
        'broj_sasije',
        'fajl'
    ];

    public function vozilo()
    {
      return $this->belongsTo(Vozila::Class,'vozilo_id');
    }
}
