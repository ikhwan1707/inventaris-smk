@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Peminjaman' => route('peminjaman.index'),
    'Tambah' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-hand-holding"></i> Tambah Peminjaman
                </div>
                <div class="card-body">
                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf

                        {{-- =====================
                        BARIS 1: Kode Peminjaman
                        ====================== --}}
                        <div class="form-group">
                            <label>Kode Peminjaman</label>
                            <input type="text" class="form-control bg-light" value="{{ $kode }}" readonly>
                            <small class="form-text text-muted">
                                Kode peminjaman digenerate otomatis oleh sistem.
                            </small>
                        </div>

                        {{-- =====================
                        BARIS 2: Barang
                        ====================== --}}
                        <div class="form-group">
                            <label>Barang <span class="text-danger">*</span></label>
                            <select name="item_id" class="form-control @error('item_id') is-invalid @enderror" required
                                autofocus>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barang as $b)
                                <option value="{{ $b->id }}" {{ old('item_id')==$b->id ? 'selected' : '' }}>
                                    {{ $b->kode_barang }} - {{ $b->nama_barang }}
                                    (Stok: {{ $b->jumlah }} {{ $b->satuan }})
                                </option>
                                @endforeach
                            </select>
                            @error('item_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- =====================
                        BARIS 3: Peminjam & Kelas/Unit
                        ====================== --}}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama Peminjam <span class="text-danger">*</span></label>
                                <input type="text" name="nama_peminjam"
                                    class="form-control @error('nama_peminjam') is-invalid @enderror"
                                    value="{{ old('nama_peminjam') }}" placeholder="Contoh: Budi Santoso" required>
                                @error('nama_peminjam')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Kelas / Unit</label>
                                <input type="text" name="kelas_atau_unit"
                                    class="form-control @error('kelas_atau_unit') is-invalid @enderror"
                                    value="{{ old('kelas_atau_unit') }}"
                                    placeholder="Contoh: XII RPL 1, Guru, Staff TU">
                                @error('kelas_atau_unit')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- =====================
                        BARIS 4: Tanggal Pinjam & Rencana Kembali
                        ====================== --}}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tanggal Pinjam <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_pinjam"
                                    class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                    value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                                @error('tanggal_pinjam')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Rencana Kembali <span class="text-danger">*</span></label>
                                <input type="date" name="rencana_kembali"
                                    class="form-control @error('rencana_kembali') is-invalid @enderror"
                                    value="{{ old('rencana_kembali', date('Y-m-d', strtotime('+1 day'))) }}" required>
                                @error('rencana_kembali')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">
                                    Tidak boleh sebelum tanggal pinjam.
                                </small>
                            </div>
                        </div>

                        {{-- =====================
                        BARIS 5: Jumlah
                        ====================== --}}
                        <div class="form-group">
                            <label>Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah"
                                class="form-control @error('jumlah') is-invalid @enderror"
                                value="{{ old('jumlah', 1) }}" min="1" required>
                            @error('jumlah')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Stok barang akan berkurang selama masa peminjaman.
                            </small>
                        </div>

                        {{-- =====================
                        BARIS 6: Keterangan
                        ====================== --}}
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" rows="3"
                                class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- =====================
                        TOMBOL AKSI
                        ====================== --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection