<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sppd extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_surat',
        'pegawai_id',
        'jenis_sppd_id',
        'kegiatan_id',
        'jenis',
        'kendaraan',
        'tgl_berangkat',
        'tgl_kembali',
        'tujuan',
        'dasar',
        'perihal'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
    public function jenis_sppd()
    {
        return $this->belongsTo(Jenis_sppd::class);
    }
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }
}