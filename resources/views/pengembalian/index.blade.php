@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Pengembalian' => route('pengembalian.index'),
    ]])

    @include('partials.alert')

    @include('partials.page-header', [
    'title' => 'Data Pengembalian',
    'icon' => 'undo',
    'action' => '<a href="' . route('pengembalian.create') . '" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Pengembalian
    </a>'
    ])

    {{-- FILTER --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('pengembalian.index') }}" class="form-row">
                <div class="col-md-3 mb-2">
                    <label class="mb-0 small">Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="mb-0 small">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="mb-0 small">Kondisi Akhir</label>
                    <select name="condition_id" class="form-control">
                        <option value="">-- Semua Kondisi --</option>
                        @foreach(\App\Condition::orderBy('nama_kondisi')->get() as $c)
                        <option value="{{ $c->id }}" {{ request('condition_id')==$c->id ? 'selected' : '' }}>
                            {{ $c->nama_kondisi }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2 d-flex align-items-end">
                    <button class="btn btn-secondary mr-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('pengembalian.index') }}" class="btn btn-light">
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
                        <th>Kode Peminjaman</th>
                        <th>Barang</th>
                        <th>Peminjam</th>
                        <th class="text-right">Jumlah</th>
                        <th>Tgl Kembali</th>
                        <th>Kondisi Akhir</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $d)
                    <tr>
                        <td class="text-center">{{ $data->firstItem() + $i }}</td>
                        <td>
                            <span class="badge badge-secondary">
                                {{ $d->loan->kode_peminjaman ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $d->loan->item->nama_barang ?? '-' }}</strong>
                        </td>
                        <td>
                            {{ $d->loan->nama_peminjam ?? '-' }}
                            @if($d->loan->kelas_atau_unit)
                            <br><small class="text-muted">{{ $d->loan->kelas_atau_unit }}</small>
                            @endif
                        </td>
                        <td class="text-right">
                            <span class="badge badge-success">
                                {{ $d->loan->jumlah ?? 0 }} {{ $d->loan->item->satuan ?? '' }}
                            </span>
                        </td>
                        <td>
                            <i class="far fa-calendar-check text-muted"></i>
                            {{ \Carbon\Carbon::parse($d->tanggal_kembali)->format('d-m-Y') }}
                        </td>
                        <td>
                            @php
                            $namaKondisi = $d->condition->nama_kondisi ?? '-';
                            $badgeClass = 'badge-secondary';
                            if (stripos($namaKondisi, 'baik') !== false) {
                            $badgeClass = 'badge-success';
                            } elseif (stripos($namaKondisi, 'ringan') !== false) {
                            $badgeClass = 'badge-warning';
                            } elseif (stripos($namaKondisi, 'berat') !== false || stripos($namaKondisi, 'rusak') !==
                            false) {
                            $badgeClass = 'badge-danger';
                            }
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ $namaKondisi }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pengembalian.show', $d->id) }}" class="btn btn-sm btn-info"
                                title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('pengembalian.edit', $d->id) }}" class="btn btn-sm btn-warning"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal"
                                data-action="{{ route('pengembalian.destroy', $d->id) }}"
                                data-message="Batalkan pengembalian ini? Status peminjaman '{{ $d->loan->kode_peminjaman ?? '-' }}' akan kembali menjadi Dipinjam."
                                title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    @include('partials.empty-state', [
                    'colspan' => 8,
                    'message' => 'Belum ada data pengembalian.'
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