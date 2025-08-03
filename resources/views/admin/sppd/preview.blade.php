@extends('layouts.app')

@section('title', 'EXPORT SPPD')

@section('main')
<div class="container">
    <h2>Preview Data Export</h2>
    <div class="mt-3">
        <a href="{{ route('sppd.export.xls') }}" class="btn btn-success">Download Excel</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                <th>NIP</th>
                <th>No. Surat</th>
                <th>Tanggal Surat</th>
                <th>Perihal</th>
                <th>Pangkat</th>
                <th>Tujuan</th>
                <th>Tanggal Berangkat</th>
                <th>Tanggal Kembali</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sppds as $sppd)
                <tr>
                    <td>{{ $sppd->pegawai->nama }}</td>
                    <td>{{ $sppd->pegawai->nip }}</td>
                    <td>{{ $sppd->surat_keluar->no_surat }}</td>
                    <td>{{ $sppd->surat_keluar->tgl_surat }}</td>
                    <td>{{ $sppd->surat_keluar->perihal }}</td>
                    <td>{{ $sppd->pegawai->pangkat }}</td>
                    <td>{{ $sppd->tujuan }}</td>
                    <td>{{ $sppd->tgl_berangkat }}</td>
                    <td>{{ $sppd->tgl_kembali }}</td>
                    <td>{{ $sppd->biaya }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
