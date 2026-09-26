@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Edit Pengembalian</h3>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('pengembalian.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Peminjaman</label>
            <input type="text" class="form-control"
                value="{{ $data->loan->kode_peminjaman }} - {{ $data->loan->nama_peminjam }}" readonly>
        </div>

        <div class="form-group">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control"
                value="{{ old('tanggal_kembali', $data->tanggal_kembali) }}" required>
        </div>

        <div class="form-group">
            <label>Kondisi Barang</label>
            <select name="condition_id" class="form-control" required>
                @foreach($kondisi as $k)
                <option value="{{ $k->id }}" {{ old('condition_id', $data->condition_id) == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kondisi }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan', $data->keterangan) }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection