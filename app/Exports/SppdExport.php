<?php

namespace App\Exports;

use App\Models\Sppd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SppdExport implements FromCollection, WithHeadings
{
    /**
     * Ambil data yang akan diexport.
     */
    public function collection()
    {
        // Mengambil data dengan relasi
        return Sppd::with(['pegawai', 'jenis_sppd', 'kegiatan'])
            ->get()
            ->map(function ($sppd) {
                return [
                    'nama_pegawai' => $sppd->pegawai->nama, // Nama dari relasi pegawai
                    'nip' => $sppd->pegawai->nip, // NIP dari relasi pegawai
                    'no_surat' => $sppd->no_surat, // No Surat dari relasi surat_keluar
                    'tgl_surat' => $sppd->tgl_berangkat, // Tgl Surat dari relasi surat_keluar
                    'perihal' => $sppd->perihal, // Perihal dari relasi surat_keluar
                    'pangkat' => $sppd->pegawai->pangkat, // Pangkat dari relasi pegawai
                    'tujuan' => $sppd->tujuan,
                    'tgl_berangkat' => $sppd->tgl_berangkat,
                    'tgl_kembali' => $sppd->tgl_kembali,
                    'biaya' => $sppd->jenis_sppd->biaya,
                ];
            });
    }

    /**
     * Header untuk file Excel.
     */
    public function headings(): array
    {
        return [
            'Nama Pegawai',
            'NIP',
            'No Surat',
            'Tanggal Surat',
            'Perihal',
            'Pangkat',
            'Tujuan',
            'Tanggal Berangkat',
            'Tanggal Kembali',
            'Biaya',
        ];
    }
}
