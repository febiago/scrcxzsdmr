@extends('layouts.app')
@section('title', 'Dasar SPPD')
@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dasar SPPD</h1>
            <a href="{{ route('dasar.create') }}" class="btn btn-success ml-auto">Tambah Dasar</a>
        </div>
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="2%">No</th>
                            <th>Dasar Pebub / Perda</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dasars as $d)
                        <tr>
                            <td>{{ $d->nomor }}</td>
                            <td>{{ $d->uraian }}</td>
                            <td>
                                <a href="{{ route('dasar.edit', $d->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('dasar.destroy', $d->id) }}" method="POST" style="display:inline-block">
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
