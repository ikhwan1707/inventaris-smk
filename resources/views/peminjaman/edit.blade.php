@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Edit Peminjaman</h3>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('peminjaman.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Kode Peminjaman</label>
            <input type="text" class="form-control" value="{{ $data->kode_peminjaman }}" readonly>
        </div>

        <div class="form-group">
            <label>Barang</label>
            <select name="item_id" class="form-control" required>
                @foreach($barang as $b)
                <option value="{{ $b->id }}" {{ old('item_id', $data->item_id) == $b->id ? 'selected' : '' }}>
                    {{ $b->kode_barang }} - {{ $b->nama_barang }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Nama Peminjam</label>
            <input type="text" name="nama_peminjam" class="form-control"
                value="{{ old('nama_peminjam', $data->nama_peminjam) }}" required>
        </div>

        <div class="form-group">
            <label>Kelas / Unit</label>
            <input type="text" name="kelas_atau_unit" class="form-control"
                value="{{ old('kelas_atau_unit', $data->kelas_atau_unit) }}">
        </div>

        <div class="form-group">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control"
                value="{{ old('tanggal_pinjam', $data->tanggal_pinjam) }}" required>
        </div>

        <div class="form-group">
            <label>Rencana Kembali</label>
            <input type="date" name="rencana_kembali" class="form-control"
                value="{{ old('rencana_kembali', $data->rencana_kembali) }}" required>
        </div>

        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $data->jumlah) }}" min="1"
                required>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan', $data->keterangan) }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection