@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Barang</h3>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('barang.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" class="form-control"
                value="{{ old('kode_barang', $data->kode_barang) }}">
        </div>

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control"
                value="{{ old('nama_barang', $data->nama_barang) }}">
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" class="form-control">
                @foreach($kategori as $k)
                <option value="{{ $k->id }}" {{ old('category_id', $data->category_id) == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kategori }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Ruangan / Lokasi</label>
            <select name="location_id" class="form-control">
                @foreach($ruangan as $r)
                <option value="{{ $r->id }}" {{ old('location_id', $data->location_id) == $r->id ? 'selected' : '' }}>
                    {{ $r->nama_ruangan }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Kondisi</label>
            <select name="condition_id" class="form-control">
                @foreach($kondisi as $c)
                <option value="{{ $c->id }}" {{ old('condition_id', $data->condition_id) == $c->id ? 'selected' : '' }}>
                    {{ $c->nama_kondisi }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $data->jumlah) }}" min="0">
        </div>

        <div class="form-group">
            <label>Satuan</label>
            <input type="text" name="satuan" class="form-control" value="{{ old('satuan', $data->satuan) }}">
        </div>

        <div class="form-group">
            <label>Tahun Pengadaan</label>
            <input type="number" name="tahun_pengadaan" class="form-control"
                value="{{ old('tahun_pengadaan', $data->tahun_pengadaan) }}">
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan', $data->keterangan) }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection