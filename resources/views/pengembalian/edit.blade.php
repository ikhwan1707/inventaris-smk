@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Pengembalian' => route('pengembalian.index'),
    'Edit' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-edit"></i> Edit Pengembalian
                </div>
                <div class="card-body">
                    <form action="{{ route('pengembalian.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- =====================
                        BARIS 1: Peminjaman (readonly)
                        ====================== --}}
                        <div class="form-group">
                            <label>Peminjaman</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ $data->loan->kode_peminjaman ?? '-' }} - {{ $data->loan->nama_peminjam ?? '-' }}"
                                readonly>
                            <small class="form-text text-muted">
                                Peminjaman tidak dapat diubah. Untuk mengganti, hapus pengembalian ini terlebih dahulu.
                            </small>
                        </div>

                        {{-- =====================
                        BARIS 2: Info Barang (readonly)
                        ====================== --}}
                        <div class="form-group">
                            <label>Barang</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ $data->loan->item->kode_barang ?? '-' }} - {{ $data->loan->item->nama_barang ?? '-' }} ({{ $data->loan->jumlah ?? 0 }} {{ $data->loan->item->satuan ?? '' }})"
                                readonly>
                        </div>

                        {{-- =====================
                        BARIS 3: Tanggal Kembali
                        ====================== --}}
                        <div class="form-group">
                            <label>Tanggal Kembali <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kembali"
                                class="form-control @error('tanggal_kembali') is-invalid @enderror"
                                value="{{ old('tanggal_kembali', $data->tanggal_kembali) }}" required autofocus>
                            @error('tanggal_kembali')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- =====================
                        BARIS 4: Kondisi Barang
                        ====================== --}}
                        <div class="form-group">
                            <label>Kondisi Barang <span class="text-danger">*</span></label>
                            <select name="condition_id" class="form-control @error('condition_id') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Kondisi --</option>
                                @foreach($kondisi as $k)
                                <option value="{{ $k->id }}" {{ old('condition_id', $data->condition_id) == $k->id ?
                                    'selected' : '' }}>
                                    {{ $k->nama_kondisi }}
                                </option>
                                @endforeach
                            </select>
                            @error('condition_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Kondisi barang di data master akan otomatis diperbarui.
                            </small>
                        </div>

                        {{-- =====================
                        BARIS 5: Keterangan
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
                            <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">
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