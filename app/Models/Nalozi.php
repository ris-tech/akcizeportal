<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nalozi extends Model
{
    use HasFactory;
    protected $table = "nalozi";
    protected $fillable = [
        'klijent_id',
        'kvartal_id',
        'gorivo_id',
        'skener_id',
        'unosilac_id'
    ];
    
    public function klijent()
    {
      return $this->belongsTo(Klijenti::Class,'klijent_id');
    }
    public function skener()
    {
      return $this->belongsTo(User::Class,'skener_id');
    }
    public function unosilac()
    {
      return $this->belongsTo(User::Class,'unosilac_id');
    }
    public function kvartal()
    {
      return $this->belongsTo(Kvartali::Class,'kvartal_id');
    }
    public function gorivo()
    {
      return $this->belongsTo(Gorivo::Class,'gorivo_id');
    }
}
