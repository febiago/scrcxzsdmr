@extends('layouts.app')
@section('title', 'Edit Jenis SPPD')
@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Jenis SPPD</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('jenis.update', $jenis->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Nama Jenis</label>
                        <input type="text" name="nama" class="form-control" required value="{{ old('nama', $jenis->nama) }}">
                        @error('nama')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Biaya</label>
                        <input type="number" name="biaya" class="form-control" required value="{{ old('biaya', $jenis->biaya) }}">
                        @error('biaya')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('jenis.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
