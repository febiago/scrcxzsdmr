<?php

namespace App\Http\Controllers;
use App\Models\Sppd;
use App\Models\Pegawai;
use App\Models\Jenis_sppd;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\SppdExport;
use Maatwebsite\Excel\Facades\Excel;
use Terbilang;

class SppdController extends Controller
{
    public function index()
    {
        $sppds = Sppd::with(['pegawai', 'jenis_sppd'])
                        ->orderBy('tgl_berangkat', 'desc')
                        ->orderBy('id', 'asc')
                        ->get();

        $data = ['type_menu' => 'sppd'];

        //return view with data
        return view('admin.sppd',$data, compact('sppds'));
    }

    public function create()
    {
        $data = ['type_menu' => 'sppd'];
        
        $pegawais = Pegawai::pluck('nama', 'id');
        $jenis = Jenis_sppd::pluck('nama', 'id');
        $kegiatans = Kegiatan::pluck('sub_kegiatan', 'id');
        $totalInti = Sppd::where('jenis', 'inti')->count() + 1;

        return view('admin.sppd.create', $data, compact('pegawais','jenis','kegiatans', 'totalInti'));
    }

    public function getSisaAnggaran($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $sisa_anggaran = $kegiatan->getSisaAnggaran();
        return response()->json(['sisa_anggaran' => $sisa_anggaran]);
    }

    public function getKendaraan(Request $request)
    {
        $pegawai = Pegawai::findOrFail($request->id);
        return $pegawai->kendaraan;
    }

    public function checkUnique(Request $request)
    {
        $messages = [
            'pegawai_id.*.unique' => 'Perjalanan Dinas Ganda',
        ];

        $pegawai_ids = $request->input('pegawai_id');
        $sppd_id = $request->input('sppd_id');

        foreach ($pegawai_ids as $key => $value) {
            $rules['pegawai_id.' . $key] = [
                'nullable',
                Rule::unique('sppds', 'pegawai_id')->where(function ($query) use ($request, $key) {
                    $query->where('tgl_berangkat', $request->input('tgl_berangkat'))
                          ->where('pegawai_id', $request->input('pegawai_id')[$key]);
                })
                ->ignore($sppd_id, 'no_surat'),
            ];
        }
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = [];
            foreach ($validator->errors()->getMessages() as $key => $messages) {
                // $key format: pegawai_id.0, pegawai_id.1, dst
                if (preg_match('/pegawai_id\\.(\\d+)/', $key, $matches)) {
                    $index = $matches[1];
                    $pegawaiId = $request->input('pegawai_id')[$index];
                    $pegawai = Pegawai::find($pegawaiId);
                    $nama = $pegawai ? $pegawai->nama : 'Pegawai ID: '.$pegawaiId;
                    foreach ($messages as $msg) {
                        $errors[] = $msg . ' (' . $nama . ')';
                    }
                } else {
                    foreach ($messages as $msg) {
                        $errors[] = $msg;
                    }
                }
            }
            return response()->json(['errors' => $errors]);
        }

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        $messages = [
            'pegawai.unique' => 'Perjalanan Dinas Ganda',
        ];

        $validator = Validator::make($request->all(), [
          'no_surat1'      => 'required',
          'no_surat2'      => 'required',
          'no_surat3'      => 'required',
          'pegawai'       => ['required',
                                  Rule::unique('sppds', 'pegawai_id')->where(function ($query) use ($request) {
                                      return $query->where('tgl_berangkat', $request->tgl_berangkat);
                                  })
                              ],
          'jenis'         => 'required',
          'kegiatan'      => 'required',
          'tgl_berangkat' => 'required',
          'tgl_kembali'   => 'required',
          'kendaraan'     => 'required',
          'tujuan'        => 'required',
          'dasar'         => 'nullable',
          'perihal'       => 'required',
                            ], $messages);

        if ($validator->fails()) {
    return response()->json([
        'status' => 'error',
        'errors' => $validator->errors()
    ], 422);
}

        // Konversi tanggal ke format Y-m-d
        $tgl_berangkat = null;
        $tgl_kembali = null;
        try {
            $tgl_berangkat = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tgl_berangkat)->format('Y-m-d');
            $tgl_kembali = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tgl_kembali)->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Format tanggal tidak valid.')->withInput();
        }

        $no_surat       = $request->no_surat1.'/'.$request->no_surat2.'/'.$request->no_surat3;
        $pegawai_id     = $request->pegawai;
        $jenis          = $request->jenis;
        $kegiatan       = $request->kegiatan;
        $kendaraan      = $request->kendaraan;
        $tujuan         = $request->tujuan;
        $dasar          = $request->filled('dasar') ? $request->dasar : '-';
        $perihal        = $request->perihal;

        // Create Perjalanan Dinas
        $sppd = Sppd::create([
            'no_surat'        => $no_surat,
            'pegawai_id'      => $pegawai_id,
            'jenis_sppd_id'   => $jenis,
            'kegiatan_id'     => $kegiatan,
            'jenis'           => 'inti',
            'kendaraan'       => $kendaraan,
            'tgl_berangkat'   => $tgl_berangkat,
            'tgl_kembali'     => $tgl_kembali,
            'tujuan'          => $tujuan,
            'dasar'           => $dasar,
            'perihal'           => $perihal
        ]);

        $nama = $request->pegawai_id;
        $angkutan = $request->angkutan;

        if (!empty($nama)) {
            foreach ($nama as $key => $pengikut) {
                $data = Sppd::create([
                    'no_surat'        => $no_surat,
                    'pegawai_id'      => $pengikut,
                    'jenis_sppd_id'   => $jenis,
                    'kegiatan_id'     => $kegiatan,
                    'jenis'           => 'pengikut',
                    'kendaraan'       => $angkutan[$key],
                    'tgl_berangkat'   => $tgl_berangkat,
                    'tgl_kembali'     => $tgl_kembali,
                    'tujuan'          => $tujuan,
                    'dasar'           => $dasar,
                    'perihal'           => $perihal
                ]);
            }
        }

        return redirect('/sppd')->with('success', 'Perjalanan Dinas berhasil ditambahkan!');
    }

    public function show($id)
    {
        $sppd = Sppd::findOrFail($id);
        return view('admin.sppd', compact('sppd'));
    }

    public function edit($id)
    {
        $data = ['type_menu' => 'sppd'];
        $sppd = Sppd::where('id', $id)->firstOrFail();
        $pegawais = Pegawai::pluck('nama', 'id');
        $jenis = Jenis_sppd::pluck('nama', 'id');
        $kegiatans = Kegiatan::pluck('sub_kegiatan', 'id');

        // Ambil semua pegawai inti dan hanya pegawai pengikut terkait dengan surat keluar ini
        $pegawaiInti = $sppd->pegawai;
        $pegawaiPengikut = Sppd::where('no_surat', $sppd->no_surat)
                        ->where('jenis', 'pengikut')
                        ->get(); 

        return view('admin.sppd.edit', $data, compact('pegawais', 'jenis', 'kegiatans', 'sppd', 'pegawaiInti', 'pegawaiPengikut'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'pegawai.unique' => 'Perjalanan Dinas Ganda',
        ];

        $validator = Validator::make($request->all(), [
            'no_surat' => 'required',
            'jenis' => 'required',
            'kegiatan' => 'required',
            'tgl_berangkat' => 'required|date',
            'tgl_kembali' => 'required|date',
            'kendaraan' => 'required',
            'tujuan' => 'required',
            'dasar' => 'nullable',
            'perihal' => 'nullable',
            'pegawai_id.*' => [
                'required',
                Rule::unique('sppds', 'pegawai_id')->where(function ($query) use ($request) {
                    return $query->whereDate('tgl_berangkat', $request->tgl_berangkat)
                                 ->whereNotIn('pegawai_id', $request->pegawai_id);
                }),
            ],
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $no_surat = $request->input('no_surat');

        $sppd = Sppd::where('no_surat', $no_surat)->firstOrFail();
        $sppd->pegawai_id = $request->pegawai;
        $sppd->jenis_sppd_id = $request->jenis;
        $sppd->kegiatan_id = $request->kegiatan;
        $sppd->tgl_berangkat = $request->tgl_berangkat;
        $sppd->tgl_kembali = $request->tgl_kembali;
        $sppd->kendaraan = $request->kendaraan;
        $sppd->tujuan = $request->tujuan;
        $sppd->dasar = $request->filled('dasar') ? $request->dasar : '-';
        $sppd->perihal = $request->filled('perihal') ? $request->perihal : '-';
        $sppd->save();


        // Update pengikut
        $nama = $request->pegawai_id;
        $angkutan = $request->angkutan;

        // Check if $nama is not null and is an array
        if (!empty($nama)) {
            foreach ($nama as $key => $pengikut) {
                // Cek apakah entitas sudah ada berdasarkan ID pengikut
                $existingSppd = Sppd::where('no_surat', $no_surat)
                                    ->where('jenis', 'pengikut')
                                    ->where('pegawai_id', $pengikut)
                                    ->first();

                if ($existingSppd) {
                    // Jika entitas sudah ada, lakukan pembaruan (update)
                    $existingSppd->update([
                        'jenis_sppd_id' => $request->jenis,
                        'kegiatan_id' => $request->kegiatan,
                        'kendaraan' => $angkutan[$key],
                        'tgl_berangkat' => $request->tgl_berangkat,
                        'tgl_kembali' => $request->tgl_kembali,
                        'tujuan' => $request->tujuan,
                        'dasar' => $request->filled('dasar') ? $request->dasar : '-',
                        'perihal' => $request->filled('perihal') ? $request->perihal : '-',
                    ]);
                } else {
                    // Jika entitas belum ada, buat entitas baru
                    $sppd_pengikut = Sppd::create([
                        'no_surat' => $no_surat,
                        'jenis' => 'pengikut',
                        'pegawai_id' => $pengikut,
                        'jenis_sppd_id' => $request->jenis,
                        'kegiatan_id' => $request->kegiatan,
                        'kendaraan' => $angkutan[$key],
                        'tgl_berangkat' => $request->tgl_berangkat,
                        'tgl_kembali' => $request->tgl_kembali,
                        'tujuan' => $request->tujuan,
                        'dasar' => $request->filled('dasar') ? $request->dasar : '-',
                        'perihal' => $request->filled('perihal') ? $request->perihal : '-',
                    ]);
                }
            }
        }
        return redirect()->route('sppd.index')->with('success', 'Perjalanan Dinas berhasil diperbarui!');

    }

    public function delete($id)
    {
        //delete post by ID
        Sppd::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }

    public function destroy($id)
    {
        //delete post by ID
        Sppd::where('no_surat', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }

    public function deleteByNoSurat(Request $request)
    {
        $no_surat = $request->input('no_surat');
        if (!$no_surat) {
            return response()->json(['message' => 'No Surat tidak ditemukan.'], 400);
        }

        $deleted = Sppd::where('no_surat', $no_surat)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Semua data dengan No Surat ' . $no_surat . ' berhasil dihapus.']);
        } else {
            return response()->json(['message' => 'Tidak ada data yang dihapus.'], 404);
        }
    }

    public function printPDF($id)
    {
        $data = Sppd::find($id);
        $no_surat = $data->no_surat;
        $sppd = Sppd::with(['pegawai', 'jenis_sppd'])
                 ->where('no_surat', $no_surat)
                 ->get();
        $pengikut = Sppd::with(['pegawai', 'jenis_sppd'])
                 ->where('no_surat', $no_surat)
                 ->where('jenis', 'pengikut')
                 ->get();
        $jenis = Jenis_sppd::where('id', $data->jenis_sppd_id)->first();
        $jumlah = count($sppd)*$jenis->biaya;
        $terbilangku = Terbilang::make($jumlah);

        $camat = Pegawai::where('jabatan', 'like', '%Camat%')->first();
        $bendahara = Pegawai::where('jabatan', 'like', '%Bendahara%')->first();
        $tgl_berangkat = Carbon::parse($data->tgl_berangkat)->isoFormat(('DD MMMM Y'));
        $waktu = Carbon::parse($data->tgl_berangkat)->isoFormat(('dddd, DD MMMM Y'));
        $tgl_kembali = Carbon::parse($data->tgl_kembali)->isoFormat(('DD MMMM Y'));


        $carbonTglBerangkat = Carbon::createFromFormat('Y-m-d', $data->tgl_berangkat);
        $carbonTglKembali = Carbon::createFromFormat('Y-m-d', $data->tgl_kembali);
        $hari = $carbonTglKembali->diffInDays($carbonTglBerangkat);

        $pdf = PDF::loadView('pdf.sppd', [
            'data' => $sppd, 
            'tgl_berangkat' => $tgl_berangkat, 
            'tgl_kembali' => $tgl_kembali,
            'camat' => $camat,
            'bendahara' => $bendahara,
            'hari' => $hari,
            'pengikut' => $pengikut,
            'jumlah' => $jumlah,
            'waktu' => $waktu

        ]);

        return $pdf->stream('sppd.pdf');
    }

    public function exportXls()
    {
        return Excel::download(new SppdExport, 'laporan-sppd.xlsx');
    }

    public function previewExport()
    {
        // Ambil data dengan relasi yang dibutuhkan
        $sppds = Sppd::with(['pegawai', 'jenis_sppd', 'kegiatan'])->get();
        $data = ['type_menu' => 'rekap'];
    
        // Kirim data ke view
        return view('admin.sppd.preview', $data,compact('sppds'));
    }



}
