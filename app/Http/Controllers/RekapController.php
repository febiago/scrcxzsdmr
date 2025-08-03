<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sppd;
use App\Models\Surat_keluar;
use App\Models\Jenis_sppd;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function index()
    {
        $data = ['type_menu' => 'rekap'];

        //return view with data
        return view('admin.rekap',$data);
    }

    public function filter(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Menggunakan DB::raw() untuk melakukan operasi agregasi SUM pada kolom biaya
        $sppd = DB::table('sppds')
                ->join('kegiatans', 'sppds.kegiatan_id', '=', 'kegiatans.id')
                ->join('jenis_sppds', 'sppds.jenis_sppd_id', '=', 'jenis_sppds.id')
                ->select('kegiatans.nm_kegiatan', 'kegiatans.sub_kegiatan', 'jenis_sppds.nama', DB::raw('COUNT(sppds.id) as jumlah') ,DB::raw('SUM(jenis_sppds.biaya) as total_biaya'))
                ->whereDate('sppds.tgl_berangkat', '>=', $tanggalAwal)
                ->whereDate('sppds.tgl_berangkat', '<=', $tanggalAkhir)
                ->groupBy('kegiatans.nm_kegiatan', 'kegiatans.sub_kegiatan', 'jenis_sppds.nama')
                ->get();

        return response()->json($sppd);
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::find($id);
            //return response
        if($kegiatan){
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Kegiatan',
                'data'    => $kegiatan
            ]); 
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data Kegiatan Tidak Ditemukan',
                'data'    => null
            ]); 
        }
    }

    public function update(Request $request, $id_kegiatan)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'kode'         => 'required',
            'program'      => 'required',
            'nm_kegiatan'  => 'required',
            'sub_kegiatan' => 'required',
            'anggaran'     => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //create post
        $kegiatan = Kegiatan::findOrFail($id_kegiatan);
        $kegiatan->update($request->all());

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil di-update!',
            'data' => $kegiatan,
        ]);
    }

    public function destroy($id)
    {
        //delete post by ID
        Kegiatan::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }


}