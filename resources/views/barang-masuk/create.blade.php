@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Barang Masuk' => route('barang-masuk.index'),
    'Tambah' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-arrow-down"></i> Tambah Barang Masuk
                </div>
                <div class="card-body">
                    <form action="{{ route('barang-masuk.store') }}" method="POST">
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
                                <label>Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_masuk"
                                    class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                    value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                                @error('tanggal_masuk')
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
                                    Stok barang akan bertambah sesuai jumlah ini.
                                </small>
                            </div>
                        </div>

                        {{-- =====================
                        BARIS 3: Sumber
                        ====================== --}}
                        <div class="form-group">
                            <label>Sumber</label>
                            <input type="text" name="sumber" class="form-control @error('sumber') is-invalid @enderror"
                                value="{{ old('sumber') }}" placeholder="Contoh: Pembelian, Hibah, Bantuan Pemerintah">
                            @error('sumber')
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
                            <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">
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