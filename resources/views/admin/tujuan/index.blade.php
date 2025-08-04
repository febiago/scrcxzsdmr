@extends('layouts.app')
@section('title', 'Tujuan')
@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tujuan</h1>
            <a href="{{ route('tujuan.create') }}" class="btn btn-success ml-auto">Tambah Tujuan</a>
        </div>
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tujuan</th>
                            <th>Pejabat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tujuans as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->tujuan }}</td>
                            <td>{{ $t->pejabat }}</td>
                            <td>
                                <a href="{{ route('tujuan.edit', $t->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('tujuan.destroy', $t->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
