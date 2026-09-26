@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Data Pengembalian</h3>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('pengembalian.index') }}" class="form-inline">
                <div class="form-group mr-2">
                    <label class="mr-1">Dari</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="form-group mr-2">
                    <label class="mr-1">Sampai</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <button class="btn btn-secondary mr-2">Filter</button>
                <a href="{{ route('pengembalian.index') }}" class="btn btn-light">Reset</a>
            </form>
        </div>
    </div>

    <a href="{{ route('pengembalian.create') }}" class="btn btn-primary mb-3">+ Tambah Pengembalian</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Peminjaman</th>
                <th>Barang</th>
                <th>Peminjam</th>
                <th>Jumlah</th>
                <th>Tgl Kembali</th>
                <th>Kondisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $d)
            <tr>
                <td>{{ $data->firstItem() + $i }}</td>
                <td>{{ $d->loan->kode_peminjaman ?? '-' }}</td>
                <td>{{ $d->loan->item->nama_barang ?? '-' }}</td>
                <td>{{ $d->loan->nama_peminjam ?? '-' }}</td>
                <td>{{ $d->loan->jumlah ?? 0 }} {{ $d->loan->item->satuan ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal_kembali)->format('d-m-Y') }}</td>
                <td>{{ $d->condition->nama_kondisi ?? '-' }}</td>
                <td>
                    <a href="{{ route('pengembalian.show', $d->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('pengembalian.edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pengembalian.destroy', $d->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Batalkan pengembalian ini? Status akan kembali Dipinjam.')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada data pengembalian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $data->links() }}
</div>
@endsection