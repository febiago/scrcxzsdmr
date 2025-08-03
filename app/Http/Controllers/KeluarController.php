<?php

namespace App\Http\Controllers;
use App\Models\Surat_keluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeluarController extends Controller
{
    /**
     * index
     *
     * @return void
     */

    public function index()
    {
        $skeluar = Surat_keluar::orderBy('tgl_surat', 'desc')
                        ->orderBy('id', 'asc')
                        ->get();
        $data = ['type_menu' => 'surat-keluar'];
        $suratKeluar = new Surat_keluar();
        $jumlahSuratKeluar = $suratKeluar->getJumlahSuratKeluar();
        $nomorSurat = $jumlahSuratKeluar + 1;

        //return view with data
        return view('admin.keluar',$data, compact('skeluar'))->with('nomorSurat', $nomorSurat);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'no_surat1'     => 'required',
            'no_surat2'     => 'required',
            'perihal'       => 'required',
            'tgl_surat'     => 'required',
            'tgl_dikirim'   => 'required',
            'ditujukan'     => 'required',
            'kategori'      => 'nullable',
            'keterangan'    => 'nullable',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());
        }

        //create post
        $no_surat = $request->no_surat1.'/'.$request->no_surat2.'/408.63/2025';
        $keluar = Surat_keluar::create([
            'no_surat'      => $no_surat,
            'perihal'       => $request->perihal,
            'tgl_surat'     => $request->tgl_surat,
            'tgl_dikirim'   => $request->tgl_dikirim,
            'ditujukan'     => $request->ditujukan,
            'kategori'      => $request->filled('kategori') ? $request->kategori : '-',
            'keterangan'    => $request->filled('keterangan') ? $request->keterangan : '...',
            'image'         => $request->filled('image') ? $request->image : 'null.jpg',
        ]);
        
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $keluar  
        ]);
    }

    public function show($id)
    {
        $keluar = Surat_keluar::find($id);
            //return response
        if($keluar){
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Surat Keluar',
                'data'    => $keluar
            ]); 
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data Surat Keluar Tidak Ditemukan',
                'data'    => null
            ]); 
        }
    }
    
    public function update(Request $request, $id_skeluar)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'no_surat'      => 'required',
            'perihal'       => 'required',
            'tgl_surat'     => 'required',
            'tgl_dikirim'   => 'required',
            'ditujukan'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //create post
        $sKeluar = Surat_keluar::findOrFail($id_skeluar);
        $sKeluar->update($request->all());

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil di-update!',
            'data' => $sKeluar,
        ]);
    }

    public function destroy($id)
    {
        //delete post by ID
        Surat_keluar::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }
}

