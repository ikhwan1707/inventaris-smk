@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Laporan Barang Keluar</h3>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.barang-keluar') }}" class="form-row">
                <div class="col-md-3 mb-2">
                    <label class="mb-0">Dari</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="mb-0">Sampai</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="mb-0">Barang</label>
                    <select name="item_id" class="form-control">
                        <option value="">-- Semua Barang --</option>
                        @foreach($barang as $b)
                        <option value="{{ $b->id }}" {{ request('item_id')==$b->id ? 'selected' : '' }}>
                            {{ $b->nama_barang }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2 d-flex align-items-end">
                    <button class="btn btn-secondary mr-2">Filter</button>
                    <a href="{{ route('laporan.barang-keluar') }}" class="btn btn-light mr-2">Reset</a>
                    <a href="{{ route('laporan.barang-keluar.pdf') . '?' . http_build_query(request()->query()) }}"
                        target="_blank" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Tujuan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->tanggal_keluar)->format('d-m-Y') }}</td>
                    <td>{{ $d->item->kode_barang ?? '-' }}</td>
                    <td>{{ $d->item->nama_barang ?? '-' }}</td>
                    <td>{{ $d->item->category->nama_kategori ?? '-' }}</td>
                    <td class="text-right">{{ $d->jumlah }}</td>
                    <td>{{ $d->tujuan ?? '-' }}</td>
                    <td>{{ $d->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">Total Jumlah</th>
                    <th class="text-right">{{ $total }}</th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection