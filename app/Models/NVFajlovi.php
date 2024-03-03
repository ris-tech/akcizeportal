<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NVFajlovi extends Model
{
    use HasFactory;
    protected $table = "nv_fajlovi";
    protected $fillable = [
        'nalog_id',
        'faktura',
        'fajl_id'
    ];

    public function fajl()
    {
      return $this->belongsTo(Fajlovi::Class,'fajl_id');
    }
}
