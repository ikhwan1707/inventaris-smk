@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Ruangan' => route('ruangan.index'),
    'Edit' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-edit"></i> Edit Ruangan
                </div>
                <div class="card-body">
                    <form action="{{ route('ruangan.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama Ruangan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ruangan"
                                class="form-control @error('nama_ruangan') is-invalid @enderror"
                                value="{{ old('nama_ruangan', $data->nama_ruangan) }}"
                                placeholder="Contoh: Lab Komputer 1" required autofocus>
                            @error('nama_ruangan')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('ruangan.index') }}" class="btn btn-secondary">
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