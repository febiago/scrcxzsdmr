<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tujuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'tujuan',
        'pejabat',
    ];

    public function sppd()
    {
        return $this->hasMany(Sppd::class);
    }
}

