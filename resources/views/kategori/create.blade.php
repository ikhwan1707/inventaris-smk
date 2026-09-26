@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Kategori</h3>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori') }}">
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection