<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    use HasFactory;

    protected $table = 'kasbon';
    protected $guarded = [];

    protected $casts = [
        'tanggal_diajukan' => 'datetime',
        'tanggal_disetujui'=> 'datetime',
    ];

    
    // --------------------------------------SCOPE---------------------------------------
    public function scopeFilterKasbon($query, $bulan, $belumDisetujui = ''){
        
        return $query->where('tanggal_diajukan', 'like', '%'.$bulan.'%')
                        ->when($belumDisetujui == 1, function($query){
                            $query->where('tanggal_disetujui', null);
                        });
    }
    
    // --------------------------------------RELASI---------------------------------------
    public function pegawai(){
        
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
