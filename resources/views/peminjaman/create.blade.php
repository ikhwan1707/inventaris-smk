@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Tambah Peminjaman</h3>

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Kode Peminjaman</label>
            <input type="text" class="form-control" value="{{ $kode }}" readonly>
        </div>

        <div class="form-group">
            <label>Barang</label>
            <select name="item_id" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barang as $b)
                <option value="{{ $b->id }}" {{ old('item_id')==$b->id ? 'selected' : '' }}>
                    {{ $b->kode_barang }} - {{ $b->nama_barang }}
                    (Stok: {{ $b->jumlah }} {{ $b->satuan }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Nama Peminjam</label>
            <input type="text" name="nama_peminjam" class="form-control" value="{{ old('nama_peminjam') }}" required>
        </div>

        <div class="form-group">
            <label>Kelas / Unit</label>
            <input type="text" name="kelas_atau_unit" class="form-control" value="{{ old('kelas_atau_unit') }}"
                placeholder="Contoh: XII RPL 1, Guru, Staff TU">
        </div>

        <div class="form-group">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control"
                value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label>Rencana Kembali</label>
            <input type="date" name="rencana_kembali" class="form-control"
                value="{{ old('rencana_kembali', date('Y-m-d', strtotime('+1 day'))) }}" required>
        </div>

        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', 1) }}" min="1" required>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection