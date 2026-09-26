@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Barang Masuk</h3>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('barang-masuk.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Barang</label>
            <select name="item_id" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barang as $b)
                <option value="{{ $b->id }}" {{ old('item_id')==$b->id ? 'selected' : '' }}>
                    {{ $b->kode_barang }} - {{ $b->nama_barang }} (Stok: {{ $b->jumlah }} {{ $b->satuan }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control"
                value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', 1) }}" min="1" required>
        </div>

        <div class="form-group">
            <label>Sumber</label>
            <input type="text" name="sumber" class="form-control" value="{{ old('sumber') }}"
                placeholder="Contoh: Pembelian, Hibah, Bantuan Pemerintah">
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection