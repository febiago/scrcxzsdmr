@extends('layouts.app')
@section('title', 'Tambah Jenis SPPD')
@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Jenis SPPD</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('jenis.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Jenis</label>
                        <input type="text" name="nama" class="form-control" required value="{{ old('nama') }}">
                        @error('nama')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Biaya</label>
                        <input type="number" name="biaya" class="form-control" required value="{{ old('biaya') }}">
                        @error('biaya')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('jenis.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
