@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Tambah Pengembalian</h3>

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

    <form action="{{ route('pengembalian.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Peminjaman</label>
            <select name="loan_id" class="form-control" required>
                <option value="">-- Pilih Peminjaman --</option>
                @foreach($peminjaman as $p)
                <option value="{{ $p->id }}" {{ old('loan_id', $loan_id)==$p->id ? 'selected' : '' }}>
                    {{ $p->kode_peminjaman }} - {{ $p->nama_peminjam }}
                    ({{ $p->item->nama_barang ?? '-' }} × {{ $p->jumlah }})
                </option>
                @endforeach
            </select>
            <small class="text-muted">Hanya menampilkan peminjaman dengan status "Dipinjam".</small>
        </div>

        <div class="form-group">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control"
                value="{{ old('tanggal_kembali', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label>Kondisi Barang Saat Dikembalikan</label>
            <select name="condition_id" class="form-control" required>
                <option value="">-- Pilih Kondisi --</option>
                @foreach($kondisi as $k)
                <option value="{{ $k->id }}" {{ old('condition_id')==$k->id ? 'selected' : '' }}>
                    {{ $k->nama_kondisi }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection