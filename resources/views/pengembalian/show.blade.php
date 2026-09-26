@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Detail Pengembalian</h3>

    <table class="table table-bordered">
        <tr>
            <th width="200">Kode Peminjaman</th>
            <td>{{ $data->loan->kode_peminjaman ?? '-' }}</td>
        </tr>
        <tr>
            <th>Barang</th>
            <td>{{ $data->loan->item->kode_barang ?? '-' }} - {{ $data->loan->item->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $data->loan->jumlah ?? 0 }} {{ $data->loan->item->satuan ?? '' }}</td>
        </tr>
        <tr>
            <th>Nama Peminjam</th>
            <td>{{ $data->loan->nama_peminjam ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Kembali</th>
            <td>{{ \Carbon\Carbon::parse($data->tanggal_kembali)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Kondisi</th>
            <td>{{ $data->condition->nama_kondisi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td>{{ $data->keterangan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Dicatat pada</th>
            <td>{{ $data->created_at->format('d-m-Y H:i') }}</td>
        </tr>
    </table>

    <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection