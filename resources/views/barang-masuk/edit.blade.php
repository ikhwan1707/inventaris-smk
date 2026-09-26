@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Barang Masuk' => route('barang-masuk.index'),
    'Edit' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-edit"></i> Edit Barang Masuk
                </div>
                <div class="card-body">
                    <form action="{{ route('barang-masuk.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- =====================
                        BARIS 1: Barang
                        ====================== --}}
                        <div class="form-group">
                            <label>Barang <span class="text-danger">*</span></label>
                            <select name="item_id" class="form-control @error('item_id') is-invalid @enderror" required
                                autofocus>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barang as $b)
                                <option value="{{ $b->id }}" {{ old('item_id', $data->item_id) == $b->id ? 'selected' :
                                    '' }}>
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
                                    value="{{ old('tanggal_masuk', $data->tanggal_masuk) }}" required>
                                @error('tanggal_masuk')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah"
                                    class="form-control @error('jumlah') is-invalid @enderror"
                                    value="{{ old('jumlah', $data->jumlah) }}" min="1" required>
                                @error('jumlah')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">
                                    Perubahan jumlah akan otomatis menyesuaikan stok barang.
                                </small>
                            </div>
                        </div>

                        {{-- =====================
                        BARIS 3: Sumber
                        ====================== --}}
                        <div class="form-group">
                            <label>Sumber</label>
                            <input type="text" name="sumber" class="form-control @error('sumber') is-invalid @enderror"
                                value="{{ old('sumber', $data->sumber) }}"
                                placeholder="Contoh: Pembelian, Hibah, Bantuan Pemerintah">
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
                                class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $data->keterangan) }}</textarea>
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
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection