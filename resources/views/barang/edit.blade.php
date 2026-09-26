@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Barang' => route('barang.index'),
    'Edit' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-edit"></i> Edit Barang: {{ $data->nama_barang }}
                </div>
                <div class="card-body">
                    <form action="{{ route('barang.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- =====================
                        BARIS 1: Kode & Nama
                        ====================== --}}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" name="kode_barang"
                                    class="form-control @error('kode_barang') is-invalid @enderror"
                                    value="{{ old('kode_barang', $data->kode_barang) }}" placeholder="BRG-001" required
                                    autofocus>
                                @error('kode_barang')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label>Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_barang"
                                    class="form-control @error('nama_barang') is-invalid @enderror"
                                    value="{{ old('nama_barang', $data->nama_barang) }}" required>
                                @error('nama_barang')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- =====================
                        BARIS 2: Kategori, Ruangan, Kondisi
                        ====================== --}}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" {{ old('category_id', $data->category_id) == $k->id ?
                                        'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Ruangan / Lokasi <span class="text-danger">*</span></label>
                                <select name="location_id"
                                    class="form-control @error('location_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach($ruangan as $r)
                                    <option value="{{ $r->id }}" {{ old('location_id', $data->location_id) == $r->id ?
                                        'selected' : '' }}>
                                        {{ $r->nama_ruangan }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kondisi <span class="text-danger">*</span></label>
                                <select name="condition_id"
                                    class="form-control @error('condition_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kondisi --</option>
                                    @foreach($kondisi as $c)
                                    <option value="{{ $c->id }}" {{ old('condition_id', $data->condition_id) == $c->id ?
                                        'selected' : '' }}>
                                        {{ $c->nama_kondisi }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('condition_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- =====================
                        BARIS 3: Jumlah, Satuan, Tahun
                        ====================== --}}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah"
                                    class="form-control @error('jumlah') is-invalid @enderror"
                                    value="{{ old('jumlah', $data->jumlah) }}" min="0" required>
                                @error('jumlah')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Satuan <span class="text-danger">*</span></label>
                                <input type="text" name="satuan"
                                    class="form-control @error('satuan') is-invalid @enderror"
                                    value="{{ old('satuan', $data->satuan) }}" placeholder="Unit / Buah / Set" required>
                                @error('satuan')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tahun Pengadaan</label>
                                <input type="number" name="tahun_pengadaan"
                                    class="form-control @error('tahun_pengadaan') is-invalid @enderror"
                                    value="{{ old('tahun_pengadaan', $data->tahun_pengadaan) }}" min="1900"
                                    max="{{ date('Y') }}">
                                @error('tahun_pengadaan')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
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
                            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
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