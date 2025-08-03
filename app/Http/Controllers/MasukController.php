<?php

namespace App\Http\Controllers;
use App\Models\Surat_masuk;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
use Carbon\Carbon;

class MasukController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $smasuk = Surat_masuk::latest()->get();
        $data = ['type_menu' => 'surat-masuk'];

        //return view with data
        return view('admin.masuk',$data, compact('smasuk'));
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'no_surat'      => 'required',
            'pengirim'      => 'required',
            'perihal'       => 'required',
            'tgl_surat'     => 'required',
            'tgl_diterima'  => 'required',
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
        $masuk = Surat_masuk::create([
            'no_surat'      => $request->no_surat,
            'pengirim'      => $request->pengirim,
            'perihal'       => $request->perihal,
            'tgl_surat'     => $request->tgl_surat,
            'tgl_diterima'  => $request->tgl_diterima,
            'ditujukan'     => $request->ditujukan,
            'kategori'      => $request->filled('kategori') ? $request->kategori : '-',
            'keterangan'    => $request->filled('keterangan') ? $request->keterangan : '',
            'image'         => $request->filled('image') ? $request->image : 'null.jpg',
        ]);
        
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $masuk  
        ]);
    }

    public function show($id)
    {
        $masuk = Surat_masuk::find($id);
            //return response
        if($masuk){
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Surat Masuk',
                'data'    => $masuk
            ]); 
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data Surat Masuk Tidak Ditemukan',
                'data'    => null
            ]); 
        }
    }
    
    public function update(Request $request, $id_smasuk)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'no_surat'      => 'required',
            'pengirim'      => 'required',
            'perihal'       => 'required',
            'tgl_surat'     => 'required',
            'tgl_diterima'  => 'required',
            'ditujukan'     => 'required',
            'keterangan'    => 'nullable'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //create post
        $sMasuk = Surat_masuk::findOrFail($id_smasuk);
        $sMasuk->update($request->all());

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil di-update!',
            'data' => $sMasuk,
        ]);
    }

    public function destroy($id)
    {
        //delete post by ID
        Surat_masuk::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }

     public function printDispo($id)
    {
        $data = Surat_masuk::find($id);
        $tglSurat = Carbon::parse($data->tgl_surat)->format('d-m-Y');
        $tglDiterima = Carbon::parse($data->tgl_diterima)->format('d-m-Y');

        $pdf = PDF::loadView('pdf.disposisi', [
            'data' => $data, 
            'tglSurat' => $tglSurat,
            'tglDiterima' => $tglDiterima
        ]);

        return $pdf->stream('disposisi.pdf');
    }
}

