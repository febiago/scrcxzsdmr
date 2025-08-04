@extends('layouts.app')
@section('title', 'Edit Tujuan')
@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Tujuan</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('tujuan.update', $tujuan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Nama Tujuan</label>
                        <input type="text" name="nama" class="form-control" required value="{{ old('nama', $tujuan->nama) }}">
                        @error('nama')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('tujuan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
