@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Data Peminjaman</h3>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('peminjaman.index') }}" class="form-inline">
                <div class="form-group mr-2">
                    <label class="mr-1">Dari</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="form-group mr-2">
                    <label class="mr-1">Sampai</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="form-group mr-2">
                    <select name="status" class="form-control">
                        <option value="">-- Semua Status --</option>
                        <option value="Dipinjam" {{ request('status')=='Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="Kembali" {{ request('status')=='Kembali' ? 'selected' : '' }}>Kembali</option>
                    </select>
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
                <a href="{{ route('peminjaman.index') }}" class="btn btn-light">Reset</a>
            </form>
        </div>
    </div>

    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">+ Tambah Peminjaman</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Barang</th>
                <th>Peminjam</th>
                <th>Tgl Pinjam</th>
                <th>Rencana Kembali</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $d)
            <tr>
                <td>{{ $data->firstItem() + $i }}</td>
                <td>{{ $d->kode_peminjaman }}</td>
                <td>{{ $d->item->nama_barang ?? '-' }}</td>
                <td>
                    {{ $d->nama_peminjam }}<br>
                    <small class="text-muted">{{ $d->kelas_atau_unit }}</small>
                </td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal_pinjam)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($d->rencana_kembali)->format('d-m-Y') }}</td>
                <td>{{ $d->jumlah }} {{ $d->item->satuan ?? '' }}</td>
                <td>
                    @if($d->status == 'Dipinjam')
                    <span class="badge badge-warning">Dipinjam</span>
                    @else
                    <span class="badge badge-success">Kembali</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('peminjaman.show', $d->id) }}" class="btn btn-info btn-sm">Detail</a>

                    @if($d->status == 'Dipinjam')
                    <a href="{{ route('peminjaman.edit', $d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('peminjaman.destroy', $d->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus peminjaman ini? Stok akan dikembalikan.')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Belum ada data peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $data->links() }}
</div>
@endsection