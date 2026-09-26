@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Barang</h3>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('barang.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" class="form-control" value="{{ old('kode_barang') }}"
                placeholder="Contoh: BRG-001">
        </div>

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}">
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" class="form-control">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                <option value="{{ $k->id }}" {{ old('category_id')==$k->id ? 'selected' : '' }}>
                    {{ $k->nama_kategori }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Ruangan / Lokasi</label>
            <select name="location_id" class="form-control">
                <option value="">-- Pilih Ruangan --</option>
                @foreach($ruangan as $r)
                <option value="{{ $r->id }}" {{ old('location_id')==$r->id ? 'selected' : '' }}>
                    {{ $r->nama_ruangan }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Kondisi</label>
            <select name="condition_id" class="form-control">
                <option value="">-- Pilih Kondisi --</option>
                @foreach($kondisi as $c)
                <option value="{{ $c->id }}" {{ old('condition_id')==$c->id ? 'selected' : '' }}>
                    {{ $c->nama_kondisi }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', 0) }}" min="0">
        </div>

        <div class="form-group">
            <label>Satuan</label>
            <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}"
                placeholder="Contoh: Unit, Buah, Set">
        </div>

        <div class="form-group">
            <label>Tahun Pengadaan</label>
            <input type="number" name="tahun_pengadaan" class="form-control" value="{{ old('tahun_pengadaan') }}"
                min="1900" max="{{ date('Y') }}">
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection