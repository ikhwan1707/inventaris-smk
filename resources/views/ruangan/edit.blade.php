@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Ruangan</h3>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('ruangan.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Ruangan</label>
            <input type="text" name="nama_ruangan" class="form-control"
                value="{{ old('nama_ruangan', $data->nama_ruangan) }}">
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('ruangan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection