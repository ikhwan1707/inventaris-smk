@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Barang</h3>
    <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Ruangan</th>
                <th>Kondisi</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->kode_barang }}</td>
                <td>{{ $d->nama_barang }}</td>
                <td>{{ $d->category->nama_kategori ?? '-' }}</td>
                <td>{{ $d->location->nama_ruangan ?? '-' }}</td>
                <td>{{ $d->condition->nama_kondisi ?? '-' }}</td>
                <td>{{ $d->jumlah }} {{ $d->satuan }}</td>
                <td>
                    <a href="{{ route('barang.show', $d->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('barang.edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('barang.destroy', $d->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection