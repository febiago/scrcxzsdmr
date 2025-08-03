<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'pangkat',
        'jabatan',
        'kendaraan',
    ];

    public function sppd()
    {
        return $this->hasMany(Sppd::class);
    }
}