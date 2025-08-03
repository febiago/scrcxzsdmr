<?php

namespace App\Http\Controllers;
use App\Models\Pegawai;
use App\Models\Sppd;
use App\Models\Kegiatan;
use App\Models\Jenis_sppd;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Jenssegers\Date\Date;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index()
    {
        $pegawai = Pegawai::count();
        $sppd = Sppd::count();
        $total_anggaran = Kegiatan::sum('anggaran');
    
        // Ambil semua kegiatan
        $kegiatans = Kegiatan::all();

        // Hitung total sisa anggaran
        $total_sisa_anggaran = $kegiatans->sum(function($kegiatan) {
            // Ambil semua SPPD pada kegiatan ini
            $sppds = Sppd::where('kegiatan_id', $kegiatan->id)->get();
            $total_realisasi = 0;
            foreach ($sppds as $sppd) {
                $jenis = Jenis_sppd::find($sppd->jenis_sppd_id);
                $biaya = $jenis ? $jenis->biaya : 0;
                $total_realisasi += $biaya;
            }
            return $kegiatan->anggaran - $total_realisasi;
        });
    
        $data = [
            'type_menu' => 'dashboard',
            'sisa_anggaran' => $total_sisa_anggaran
        ];
    
        return view('admin.dashboard', $data, compact('sppd','pegawai','total_anggaran'));
    }

    
}
