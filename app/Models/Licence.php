<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licence extends Model
{
    use HasFactory;
    protected $table = "licence";
    protected $fillable = [
        'vozilo_id',
        'od',
        'do',
        'fajl',
    ];

    public function vozilo()
    {
      return $this->belongsTo(Vozila::Class,'vozilo_id');
    }
}
