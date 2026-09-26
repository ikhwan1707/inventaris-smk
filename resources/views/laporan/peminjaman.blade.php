@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Laporan Peminjaman</h3>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.peminjaman') }}" class="form-row">
                <div class="col-md-3 mb-2">
                    <label class="mb-0">Dari</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="mb-0">Sampai</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="mb-0">Status</label>
                    <select name="status" class="form-control">
                        <option value="">-- Semua --</option>
                        <option value="Dipinjam" {{ request('status')=='Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="Kembali" {{ request('status')=='Kembali' ? 'selected' : '' }}>Kembali</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
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
                <div class="col-md-2 mb-2 d-flex align-items-end">
                    <button class="btn btn-secondary mr-1">Filter</button>
                    <a href="{{ route('laporan.peminjaman') }}" class="btn btn-light mr-1">Reset</a>
                    <a href="{{ route('laporan.peminjaman.pdf') . '?' . http_build_query(request()->query()) }}"
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
                    <th>Kode Peminjaman</th>
                    <th>Tgl Pinjam</th>
                    <th>Barang</th>
                    <th>Peminjam</th>
                    <th>Jumlah</th>
                    <th>Rencana Kembali</th>
                    <th>Tgl Kembali</th>
                    <th>Kondisi Akhir</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $d->kode_peminjaman }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->tanggal_pinjam)->format('d-m-Y') }}</td>
                    <td>{{ $d->item->nama_barang ?? '-' }}</td>
                    <td>{{ $d->nama_peminjam }}</td>
                    <td class="text-right">{{ $d->jumlah }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->rencana_kembali)->format('d-m-Y') }}</td>
                    <td>
                        @if($d->return)
                        {{ \Carbon\Carbon::parse($d->return->tanggal_kembali)->format('d-m-Y') }}
                        @else
                        -
                        @endif
                    </td>
                    <td>{{ $d->return->condition->nama_kondisi ?? '-' }}</td>
                    <td>
                        @if($d->status == 'Dipinjam')
                        <span class="badge badge-warning">Dipinjam</span>
                        @else
                        <span class="badge badge-success">Kembali</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection