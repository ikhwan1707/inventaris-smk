@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Ruangan</h3>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('ruangan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Ruangan</label>
            <input type="text" name="nama_ruangan" class="form-control" value="{{ old('nama_ruangan') }}">
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('ruangan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection