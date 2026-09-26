@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Barang Masuk' => route('barang-masuk.index'),
    ]])

    @include('partials.alert')

    @include('partials.page-header', [
    'title' => 'Transaksi Barang Masuk',
    'icon' => 'arrow-down',
    'action' => '<a href="' . route('barang-masuk.create') . '" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Barang Masuk
    </a>'
    ])

    {{-- FILTER --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('barang-masuk.index') }}" class="form-row">
                <div class="col-md-3 mb-2">
                    <label class="mb-0 small">Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="mb-0 small">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-3 mb-2">
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
                <div class="col-md-3 mb-2 d-flex align-items-end">
                    <button class="btn btn-secondary mr-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('barang-masuk.index') }}" class="btn btn-light">
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
                        <th>Tanggal</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th class="text-right">Jumlah</th>
                        <th>Sumber</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $d)
                    <tr>
                        <td class="text-center">{{ $data->firstItem() + $i }}</td>
                        <td>
                            <i class="far fa-calendar-alt text-muted"></i>
                            {{ \Carbon\Carbon::parse($d->tanggal_masuk)->format('d-m-Y') }}
                        </td>
                        <td>
                            <span class="badge badge-secondary">
                                {{ $d->item->kode_barang ?? '-' }}
                            </span>
                        </td>
                        <td><strong>{{ $d->item->nama_barang ?? '-' }}</strong></td>
                        <td>{{ $d->item->category->nama_kategori ?? '-' }}</td>
                        <td class="text-right">
                            <span class="badge badge-success">
                                +{{ $d->jumlah }} {{ $d->item->satuan ?? '' }}
                            </span>
                        </td>
                        <td>{{ $d->sumber ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('barang-masuk.show', $d->id) }}" class="btn btn-sm btn-info"
                                title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('barang-masuk.edit', $d->id) }}" class="btn btn-sm btn-warning"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal"
                                data-action="{{ route('barang-masuk.destroy', $d->id) }}"
                                data-message="Hapus transaksi ini? Stok barang akan dikurangi {{ $d->jumlah }} {{ $d->item->satuan ?? '' }}."
                                title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    @include('partials.empty-state', [
                    'colspan' => 8,
                    'message' => 'Belum ada transaksi barang masuk.'
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