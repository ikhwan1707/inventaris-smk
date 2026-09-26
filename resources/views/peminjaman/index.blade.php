@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Peminjaman' => route('peminjaman.index'),
    ]])

    @include('partials.alert')

    @include('partials.page-header', [
    'title' => 'Data Peminjaman',
    'icon' => 'hand-holding',
    'action' => '<a href="' . route('peminjaman.create') . '" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Peminjaman
    </a>'
    ])

    {{-- FILTER --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('peminjaman.index') }}" class="form-row">
                <div class="col-md-3 mb-2">
                    <label class="mb-0 small">Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="mb-0 small">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="mb-0 small">Status</label>
                    <select name="status" class="form-control">
                        <option value="">-- Semua Status --</option>
                        <option value="Dipinjam" {{ request('status')=='Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="Kembali" {{ request('status')=='Kembali' ? 'selected' : '' }}>Kembali</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="mb-0 small">Barang</label>
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
                    <button class="btn btn-secondary mr-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-light">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card">
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Kode</th>
                        <th>Barang</th>
                        <th>Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th class="text-right">Jumlah</th>
                        <th class="text-center">Status</th>
                        <th width="220" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $d)
                    @php
                    $terlambat = $d->status == 'Dipinjam'
                    && \Carbon\Carbon::parse($d->rencana_kembali)->isPast();
                    @endphp
                    <tr class="{{ $terlambat ? 'table-danger' : '' }}">
                        <td class="text-center">{{ $data->firstItem() + $i }}</td>
                        <td>
                            <span class="badge badge-secondary">{{ $d->kode_peminjaman }}</span>
                        </td>
                        <td>{{ $d->item->nama_barang ?? '-' }}</td>
                        <td>
                            <strong>{{ $d->nama_peminjam }}</strong>
                            @if($d->kelas_atau_unit)
                            <br><small class="text-muted">{{ $d->kelas_atau_unit }}</small>
                            @endif
                        </td>
                        <td>
                            <i class="far fa-calendar-alt text-muted"></i>
                            {{ \Carbon\Carbon::parse($d->tanggal_pinjam)->format('d-m-Y') }}
                        </td>
                        <td>
                            <i class="far fa-calendar-check text-muted"></i>
                            {{ \Carbon\Carbon::parse($d->rencana_kembali)->format('d-m-Y') }}
                            @if($terlambat)
                            <br><span class="badge badge-danger">
                                <i class="fas fa-exclamation-triangle"></i> Terlambat
                            </span>
                            @endif
                        </td>
                        <td class="text-right">
                            <span class="badge badge-info">
                                {{ $d->jumlah }} {{ $d->item->satuan ?? '' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($d->status == 'Dipinjam')
                            <span class="badge badge-warning">Dipinjam</span>
                            @else
                            <span class="badge badge-success">Kembali</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('peminjaman.show', $d->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            @if($d->status == 'Dipinjam')
                            <a href="{{ route('pengembalian.create', ['loan_id' => $d->id]) }}"
                                class="btn btn-sm btn-success" title="Proses Pengembalian">
                                <i class="fas fa-undo"></i>
                            </a>
                            <a href="{{ route('peminjaman.edit', $d->id) }}" class="btn btn-sm btn-warning"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal"
                                data-action="{{ route('peminjaman.destroy', $d->id) }}"
                                data-message="Hapus peminjaman '{{ $d->kode_peminjaman }}'? Stok barang akan dikembalikan."
                                title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    @include('partials.empty-state', [
                    'colspan' => 9,
                    'message' => 'Belum ada data peminjaman.'
                    ])
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    @include('partials.pagination-info', ['data' => $data])

</div>
@endsection