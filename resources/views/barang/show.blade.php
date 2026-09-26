@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Barang</h3>

    <table class="table table-bordered">
        <tr>
            <th width="200">Kode Barang</th>
            <td>{{ $data->kode_barang }}</td>
        </tr>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $data->nama_barang }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $data->category->nama_kategori ?? '-' }}</td>
        </tr>
        <tr>
            <th>Ruangan</th>
            <td>{{ $data->location->nama_ruangan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kondisi</th>
            <td>{{ $data->condition->nama_kondisi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $data->jumlah }} {{ $data->satuan }}</td>
        </tr>
        <tr>
            <th>Tahun Pengadaan</th>
            <td>{{ $data->tahun_pengadaan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td>{{ $data->keterangan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Dibuat</th>
            <td>{{ $data->created_at }}</td>
        </tr>
        <tr>
            <th>Diperbarui</th>
            <td>{{ $data->updated_at }}</td>
        </tr>
    </table>

    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection