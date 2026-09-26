@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Barang Keluar</h3>

    <table class="table table-bordered">
        <tr>
            <th width="200">Tanggal Keluar</th>
            <td>{{ \Carbon\Carbon::parse($data->tanggal_keluar)->format('d-m-Y') }}</td>
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
            <th>Tujuan</th>
            <td>{{ $data->tujuan ?? '-' }}</td>
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

    <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection