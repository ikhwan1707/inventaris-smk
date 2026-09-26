@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Transaksi Barang Keluar</h3>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('barang-keluar.index') }}" class="form-inline">
                <div class="form-group mr-2">
                    <label class="mr-1">Dari</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="form-group mr-2">
                    <label class="mr-1">Sampai</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="form-group mr-2">
                    <select name="item_id" class="form-control">
                        <option value="">-- Semua Barang --</option>
                        @foreach($barang as $b)
                        <option value="{{ $b->id }}" {{ request('item_id')==$b->id ? 'selected' : '' }}>
                            {{ $b->nama_barang }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-secondary mr-2">Filter</button>
                <a href="{{ route('barang-keluar.index') }}" class="btn btn-light">Reset</a>
            </form>
        </div>
    </div>

    <a href="{{ route('barang-keluar.create') }}" class="btn btn-primary mb-3">+ Tambah Barang Keluar</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tujuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $d)
            <tr>
                <td>{{ $data->firstItem() + $i }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal_keluar)->format('d-m-Y') }}</td>
                <td>{{ $d->item->kode_barang ?? '-' }}</td>
                <td>{{ $d->item->nama_barang ?? '-' }}</td>
                <td>{{ $d->jumlah }} {{ $d->item->satuan ?? '' }}</td>
                <td>{{ $d->tujuan ?? '-' }}</td>
                <td>
                    <a href="{{ route('barang-keluar.show', $d->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('barang-keluar.edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('barang-keluar.destroy', $d->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus transaksi ini? Stok akan dikembalikan.')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @include('partials.pagination-info', ['data' => $data])
</div>
@endsection