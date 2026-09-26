@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Barang Masuk</h3>

    <table class="table table-bordered">
        <tr>
            <th width="200">Tanggal Masuk</th>
            <td>{{ \Carbon\Carbon::parse($data->tanggal_masuk)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Kode Barang</th>
            <td>{{ $data->item->kode_barang ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $data->item->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $data->jumlah }} {{ $data->item->satuan ?? '' }}</td>
        </tr>
        <tr>
            <th>Sumber</th>
            <td>{{ $data->sumber ?? '-' }}</td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td>{{ $data->keterangan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Dicatat pada</th>
            <td>{{ $data->created_at }}</td>
        </tr>
    </table>

    <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection