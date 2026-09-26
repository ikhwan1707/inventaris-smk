@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Barang Keluar' => route('barang-keluar.index'),
    'Tambah' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-arrow-up"></i> Tambah Barang Keluar
                </div>
                <div class="card-body">
                    <form action="{{ route('barang-keluar.store') }}" method="POST">
                        @csrf

                        {{-- =====================
                        BARIS 1: Barang
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
                        BARIS 2: Tanggal & Jumlah
                        ====================== --}}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tanggal Keluar <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_keluar"
                                    class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                    value="{{ old('tanggal_keluar', date('Y-m-d')) }}" required>
                                @error('tanggal_keluar')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah"
                                    class="form-control @error('jumlah') is-invalid @enderror"
                                    value="{{ old('jumlah', 1) }}" min="1" required>
                                @error('jumlah')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">
                                    Jumlah tidak boleh melebihi stok barang tersedia.
                                </small>
                            </div>
                        </div>

                        {{-- =====================
                        BARIS 3: Tujuan
                        ====================== --}}
                        <div class="form-group">
                            <label>Tujuan</label>
                            <input type="text" name="tujuan" class="form-control @error('tujuan') is-invalid @enderror"
                                value="{{ old('tujuan') }}"
                                placeholder="Contoh: Laboratorium RPL, Ruang Guru, Dipinjam Siswa">
                            @error('tujuan')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- =====================
                        BARIS 4: Keterangan
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
                            <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">
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