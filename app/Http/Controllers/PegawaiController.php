<?php

namespace App\Http\Controllers;
use App\Models\Pegawai;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::latest()->get();
        $data = ['type_menu' => 'pegawai'];

        //return view with data
        return view('admin.pegawai',$data, compact('pegawais'));
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nip'      => 'required',
            'nama'     => 'required',
            'pangkat'  => 'required',
            'jabatan'  => 'nullable',
            'kendaraan'=> 'nullable',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $pegawai = Pegawai::create([
            'nip'       => $request->nip,
            'nama'      => $request->nama,
            'pangkat'   => $request->pangkat,
            'jabatan'   => $request->filled('jabatan') ? $request->jabatan : '-',
            'kendaraan' => $request->filled('kendaraan') ? $request->kendaraan : '-',
        ]);
        
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $pegawai  
        ]);
    }

    public function show($id)
    {
        $pegawai = Pegawai::find($id);
            //return response
        if($pegawai){
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Pegawai',
                'data'    => $pegawai
            ]); 
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data Pegawai Tidak Ditemukan',
                'data'    => null
            ]); 
        }
    }

    public function update(Request $request, $id_pegawai)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nip'         => 'required',
            'nama'        => 'required',
            'pangkat'     => 'required',
            'jabatan'     => 'nullable',
            'kendaraan'   => 'nullable'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //create post
        $pegawai = Pegawai::findOrFail($id_pegawai);
        $pegawai->update($request->all());

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil di-update!',
            'data' => $pegawai,
        ]);
    }

    public function destroy($id)
    {
        //delete post by ID
        Pegawai::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }


}
