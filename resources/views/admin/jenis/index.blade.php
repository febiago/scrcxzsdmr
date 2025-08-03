@extends('layouts.app')
@section('title', 'Jenis')
@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Jenis SPPD</h1>
            <a href="{{ route('jenis.create') }}" class="btn btn-success ml-auto">Tambah Jenis</a>
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
                            <th>Nama</th>
                            <th>Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jenis as $j)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $j->nama }}</td>
                            <td>{{ number_format($j->biaya) }}</td>
                            <td>
                                <a href="{{ route('jenis.edit', $j->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('jenis.destroy', $j->id) }}" method="POST" style="display:inline-block">
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
