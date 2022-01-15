<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $guarded = [];

    protected $casts = [
        'tanggal_masuk' => 'datetime'
    ];

    // --------------------------------------RELASI---------------------------------------
    public function kasbon(){
        
        return $this->hasMany(Kasbon::class, 'pegawai_id');
    }
}
