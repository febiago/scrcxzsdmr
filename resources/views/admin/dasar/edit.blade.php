@extends('layouts.app')
@section('title', 'Edit Dasar SPPD')
@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Dasar SPPD</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dasar.update', $dasar->nomor) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Nomor</label>
                        <input type="text" name="nomor" class="form-control" required value="{{ old('nomor', $dasar->nomor) }}">
                        @error('nomor')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Perbub / Perda</label>
                        <input type="text" name="uraian" class="form-control" required value="{{ old('uraian', $dasar->uraian) }}">
                        @error('uraian')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('dasar.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
