<?php

namespace App\Http\Controllers;

use App\Models\DasarSppd;
use Illuminate\Http\Request;

class DasarSppdController extends Controller
{

    public function index()
    {
        $dasars = DasarSppd::all();
        $data = ['type_menu' => 'nomor'];
        return view('admin.dasar.index',$data ,compact('dasars'));
    }

    public function create()
    {
        return view('admin.dasar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required',
            'uraian' => 'required',
        ]);
        DasarSppd::create($request->only('nomor', 'uraian'));
        return redirect()->route('dasar.index')->with('success', 'DasarSppd berhasil ditambahkan!');
    }

    public function show(DasarSppd $dasar)
    {
        return view('admin.dasar.show', compact('dasar'));
    }

    public function edit(DasarSppd $dasar)
    {
        return view('admin.dasar.edit', compact('dasar'));
    }

    public function update(Request $request, DasarSppd $dasar)
    {
        $request->validate([
            'nomor' => 'required',
            'uraian' => 'required',
        ]);
        $dasar->update($request->only('nomor', 'uraian'));
        return redirect()->route('dasar.index')->with('success', 'DasarSppd berhasil diupdate!');
    }

    public function destroy(DasarSppd $dasar)
    {
        $dasar->delete();
        return redirect()->route('dasar.index')->with('success', 'DasarSppd berhasil dihapus!');
    }
}
