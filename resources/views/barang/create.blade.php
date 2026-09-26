@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Barang' => route('barang.index'),
    'Tambah' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-plus"></i> Tambah Barang
                </div>
                <div class="card-body">
                    <form action="{{ route('barang.store') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Kode Barang <span class="text-danger">*</span></label>
                                <input type="text" name="kode_barang"
                                    class="form-control @error('kode_barang') is-invalid @enderror"
                                    value="{{ old('kode_barang') }}" placeholder="BRG-001" required autofocus>
                                @error('kode_barang')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label>Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_barang"
                                    class="form-control @error('nama_barang') is-invalid @enderror"
                                    value="{{ old('nama_barang') }}" required>
                                @error('nama_barang')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach(\App\Category::orderBy('nama_kategori')->get() as $k)
                                    <option value="{{ $k->id }}" {{ old('category_id')==$k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Ruangan/Lokasi <span class="text-danger">*</span></label>
                                <select name="location_id"
                                    class="form-control @error('location_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach(\App\Location::orderBy('nama_ruangan')->get() as $r)
                                    <option value="{{ $r->id }}" {{ old('location_id')==$r->id ? 'selected' : '' }}>
                                        {{ $r->nama_ruangan }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('location_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kondisi <span class="text-danger">*</span></label>
                                <select name="condition_id"
                                    class="form-control @error('condition_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach(\App\Condition::orderBy('nama_kondisi')->get() as $c)
                                    <option value="{{ $c->id }}" {{ old('condition_id')==$c->id ? 'selected' : '' }}>
                                        {{ $c->nama_kondisi }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('condition_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah"
                                    class="form-control @error('jumlah') is-invalid @enderror"
                                    value="{{ old('jumlah', 0) }}" min="0" required>
                                @error('jumlah')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Satuan <span class="text-danger">*</span></label>
                                <input type="text" name="satuan"
                                    class="form-control @error('satuan') is-invalid @enderror"
                                    value="{{ old('satuan') }}" placeholder="Unit / Buah / Set" required>
                                @error('satuan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tahun Pengadaan</label>
                                <input type="number" name="tahun_pengadaan"
                                    class="form-control @error('tahun_pengadaan') is-invalid @enderror"
                                    value="{{ old('tahun_pengadaan') }}" min="1900" max="{{ date('Y') }}">
                                @error('tahun_pengadaan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
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