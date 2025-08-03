<?php

namespace App\Http\Controllers;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::latest()->get();
        $data = ['type_menu' => 'kegiatan'];

        //return view with data
        return view('admin.kegiatan',$data, compact('kegiatans'));
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'kode'          => 'required',
            'program'       => 'required',
            'nm_kegiatan'   => 'required',
            'sub_kegiatan'  => 'required',
            'anggaran'      => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $kegiatan = Kegiatan::create([
            'kode'          => $request->kode,
            'program'       => $request->program,
            'nm_kegiatan'   => $request->nm_kegiatan,
            'sub_kegiatan'  => $request->sub_kegiatan,
            'anggaran'      => $request->anggaran,
        ]);
        
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $kegiatan  
        ]);
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