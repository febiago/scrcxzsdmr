@extends('layouts.app')
@section('title', 'Tambah Tujuan')
@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Tujuan</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('tujuan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Tujuan</label>
                        <input type="text" name="tujuan" class="form-control" required value="{{ old('tujuan') }}">
                        @error('tujuan')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Pejabat</label>
                        <input type="text" name="pejabat" class="form-control" placeholder="Pejabat Penandatangan SPPD" value="{{ old('pejabat') }}">
                        @error('pejabat')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('tujuan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
