@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3>Laporan Inventaris</h3>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.inventaris') }}" class="form-row">
                <div class="col-md-2 mb-2">
                    <select name="category_id" class="form-control">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ request('category_id')==$k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <select name="location_id" class="form-control">
                        <option value="">-- Semua Ruangan --</option>
                        @foreach($ruangan as $r)
                        <option value="{{ $r->id }}" {{ request('location_id')==$r->id ? 'selected' : '' }}>
                            {{ $r->nama_ruangan }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <select name="condition_id" class="form-control">
                        <option value="">-- Semua Kondisi --</option>
                        @foreach($kondisi as $c)
                        <option value="{{ $c->id }}" {{ request('condition_id')==$c->id ? 'selected' : '' }}>
                            {{ $c->nama_kondisi }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari kode / nama barang..."
                        value="{{ request('keyword') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <button class="btn btn-secondary">Filter</button>
                    <a href="{{ route('laporan.inventaris') }}" class="btn btn-light">Reset</a>
                    <a href="{{ route('laporan.inventaris.pdf') . '?' . http_build_query(request()->query()) }}"
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
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Ruangan</th>
                    <th>Kondisi</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Tahun</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $d->kode_barang }}</td>
                    <td>{{ $d->nama_barang }}</td>
                    <td>{{ $d->category->nama_kategori ?? '-' }}</td>
                    <td>{{ $d->location->nama_ruangan ?? '-' }}</td>
                    <td>{{ $d->condition->nama_kondisi ?? '-' }}</td>
                    <td class="text-right">{{ $d->jumlah }}</td>
                    <td>{{ $d->satuan }}</td>
                    <td>{{ $d->tahun_pengadaan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" class="text-right">Total Jumlah</th>
                    <th class="text-right">{{ $totalJumlah }}</th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection