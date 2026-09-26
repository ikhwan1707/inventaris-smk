@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Kondisi</h3>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('kondisi.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Kondisi</label>
            <input type="text" name="nama_kondisi" class="form-control"
                value="{{ old('nama_kondisi', $data->nama_kondisi) }}">
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('kondisi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection