@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Kondisi' => route('kondisi.index'),
    'Edit' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-edit"></i> Edit Kondisi Barang
                </div>
                <div class="card-body">
                    <form action="{{ route('kondisi.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama Kondisi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kondisi"
                                class="form-control @error('nama_kondisi') is-invalid @enderror"
                                value="{{ old('nama_kondisi', $data->nama_kondisi) }}"
                                placeholder="Contoh: Baik, Rusak Ringan, Rusak Berat" required autofocus>
                            @error('nama_kondisi')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Gunakan nama kondisi yang jelas, misalnya: <strong>Baik</strong>,
                                <strong>Rusak Ringan</strong>, atau <strong>Rusak Berat</strong>.
                            </small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kondisi.index') }}" class="btn btn-secondary">
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