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
        $spt = Sppd::where('jenis', 'inti')->count();
        $total = Sppd::with('jenis_sppd')->get()
                ->sum(fn($row) => $row->jenis_sppd->biaya ?? 0);
    
        $data = [
            'type_menu' => 'dashboard',
            'total' => $total,
            'spt' => $spt
        ];
        return view('admin.dashboard', $data, compact('sppd','pegawai','total','spt'));
    }

    
}
