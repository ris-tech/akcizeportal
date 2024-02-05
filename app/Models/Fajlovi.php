<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fajlovi extends Model
{
    use HasFactory;
    protected $table = "fajlovi";
    protected $fillable = [
        'nalog_id',
        'tip',
        'banka_id',
        'folder',        
        'fajl',
        'aktivan'
    ];

    public function nalog()
    {
      return $this->belongsTo(Nalozi::Class,'nalog_id');
    }
    
    public function banka()
    {
      return $this->belongsTo(Banke::Class,'banka_id');
    }

}
