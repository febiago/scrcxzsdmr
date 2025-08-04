<?php

namespace App\Http\Controllers;

use App\Models\Tujuan;
use Illuminate\Http\Request;

class TujuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tujuans = Tujuan::all();
        return view('admin.tujuan.index', compact('tujuans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tujuan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tujuan' => 'required',
            'pejabat' => 'required',
        ]);
        Tujuan::create($request->only('tujuan', 'pejabat'));
        return redirect()->route('tujuan.index')->with('success', 'Tujuan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tujuan  $tujuan
     * @return \Illuminate\Http\Response
     */
    public function show(Tujuan $tujuan)
    {
        return view('admin.tujuan.show', compact('tujuan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tujuan  $tujuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tujuan $tujuan)
    {
        return view('admin.tujuan.edit', compact('tujuan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tujuan  $tujuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tujuan $tujuan)
    {
        $request->validate([
            'tujuan' => 'required|unique:tujuans,tujuan,' . $tujuan->id,
            'pejabat' => 'required',
        ]);
        $tujuan->update($request->only('tujuan', 'pejabat'));
        return redirect()->route('tujuan.index')->with('success', 'Tujuan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tujuan  $tujuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tujuan $tujuan)
    {
        $tujuan->delete();
        return redirect()->route('tujuan.index')->with('success', 'Tujuan berhasil dihapus!');
    }
}
