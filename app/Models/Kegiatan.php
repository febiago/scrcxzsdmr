<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'program',
        'nm_kegiatan',
        'sub_kegiatan',
        'anggaran',
    ];

    public function sppd()
    {
        return $this->hasMany(Sppd::class);
    }

    public function getSisaAnggaran()
    {
        $total_biaya = Sppd::join('jenis_sppds', 'sppds.jenis_sppd_id', '=', 'jenis_sppds.id')
                        ->where('sppds.kegiatan_id', $this->id)
                        ->sum('biaya');
    
        $sisa_anggaran = $this->anggaran - $total_biaya;
        return $sisa_anggaran;
    }


}
