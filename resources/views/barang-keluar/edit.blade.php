@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Barang Keluar</h3>

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

    <form action="{{ route('barang-keluar.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

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
            <label>Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" class="form-control"
                value="{{ old('tanggal_keluar', $data->tanggal_keluar) }}" required>
        </div>

        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $data->jumlah) }}" min="1"
                required>
        </div>

        <div class="form-group">
            <label>Tujuan</label>
            <input type="text" name="tujuan" class="form-control" value="{{ old('tujuan', $data->tujuan) }}">
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan', $data->keterangan) }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection