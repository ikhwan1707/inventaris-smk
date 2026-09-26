@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Kondisi Barang</h3>
    <a href="{{ route('kondisi.create') }}" class="btn btn-primary mb-3">Tambah Kondisi</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kondisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->nama_kondisi }}</td>
                <td>
                    <a href="{{ route('kondisi.edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kondisi.destroy', $d->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Belum ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection