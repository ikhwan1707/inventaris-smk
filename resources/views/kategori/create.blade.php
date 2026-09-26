@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Kategori' => route('kategori.index'),
    'Tambah' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-plus"></i> Tambah Kategori
                </div>
                <div class="card-body">
                    <form action="{{ route('kategori.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kategori"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori') }}" placeholder="Contoh: Perangkat Komputer" required
                                autofocus>
                            @error('nama_kategori')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
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