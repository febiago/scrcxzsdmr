@extends('layouts.app')
@section('title', 'Tambah Dasar SPPD')
@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Dasar SPPD</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dasar.store') }}" method="POST">
                    @csrf
                     <div class="form-group">
                        <label>Nomor</label>
                        <input type="number" name="nomor" class="form-control" required value="{{ old('nomor') }}">
                        @error('nomor')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Perbub / Perda</label>
                        <input type="text" name="uraian" class="form-control" required value="{{ old('uraian') }}">
                        @error('uraian')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('dasar.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
