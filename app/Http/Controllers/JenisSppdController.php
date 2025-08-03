<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jenis_sppd;

class JenisSppdController extends Controller
{
    public function index()
    {
        $jenis = Jenis_sppd::all();
        return view('admin.jenis.index', compact('jenis'));
    }

    public function create()
    {
        return view('admin.jenis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:jenis_sppds,nama',
            'biaya' => 'required|numeric',
        ]);
        Jenis_sppd::create($request->only('nama', 'biaya'));
        return redirect()->route('jenis.index')->with('success', 'Jenis SPPD berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jenis = Jenis_sppd::findOrFail($id);
        return view('admin.jenis.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $jenis = Jenis_sppd::findOrFail($id);
        $request->validate([
            'nama' => 'required|unique:jenis_sppds,nama,' . $id,
            'biaya' => 'required|numeric',
        ]);
        $jenis->update($request->only('nama', 'biaya'));
        return redirect()->route('jenis.index')->with('success', 'Jenis SPPD berhasil diupdate!');
    }

    public function destroy($id)
    {
        Jenis_sppd::destroy($id);
        return redirect()->route('jenis.index')->with('success', 'Jenis SPPD berhasil dihapus!');
    }
}
