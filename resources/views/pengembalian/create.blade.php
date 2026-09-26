@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Pengembalian' => route('pengembalian.index'),
    'Tambah' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-undo"></i> Tambah Pengembalian
                </div>
                <div class="card-body">
                    <form action="{{ route('pengembalian.store') }}" method="POST">
                        @csrf

                        {{-- =====================
                        BARIS 1: Peminjaman
                        ====================== --}}
                        <div class="form-group">
                            <label>Peminjaman <span class="text-danger">*</span></label>
                            <select name="loan_id" class="form-control @error('loan_id') is-invalid @enderror" required
                                autofocus>
                                <option value="">-- Pilih Peminjaman --</option>
                                @foreach($peminjaman as $p)
                                <option value="{{ $p->id }}" {{ old('loan_id', $loan_id)==$p->id ? 'selected' : '' }}>
                                    {{ $p->kode_peminjaman }} - {{ $p->nama_peminjam }}
                                    ({{ $p->item->nama_barang ?? '-' }} × {{ $p->jumlah }} {{ $p->item->satuan ?? '' }})
                                </option>
                                @endforeach
                            </select>
                            @error('loan_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Hanya menampilkan peminjaman dengan status <strong>"Dipinjam"</strong>.
                            </small>
                        </div>

                        {{-- =====================
                        BARIS 2: Tanggal Kembali
                        ====================== --}}
                        <div class="form-group">
                            <label>Tanggal Kembali <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kembali"
                                class="form-control @error('tanggal_kembali') is-invalid @enderror"
                                value="{{ old('tanggal_kembali', date('Y-m-d')) }}" required>
                            @error('tanggal_kembali')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- =====================
                        BARIS 3: Kondisi Barang
                        ====================== --}}
                        <div class="form-group">
                            <label>Kondisi Barang Saat Dikembalikan <span class="text-danger">*</span></label>
                            <select name="condition_id" class="form-control @error('condition_id') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Kondisi --</option>
                                @foreach($kondisi as $k)
                                <option value="{{ $k->id }}" {{ old('condition_id')==$k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kondisi }}
                                </option>
                                @endforeach
                            </select>
                            @error('condition_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Kondisi barang akan diperbarui di data master sesuai pilihan ini.
                            </small>
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
                            <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">
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