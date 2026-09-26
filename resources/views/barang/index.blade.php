@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Barang' => route('barang.index'),
    ]])

    @include('partials.alert')

    @include('partials.page-header', [
    'title' => 'Data Barang',
    'icon' => 'box',
    'action' => '<a href="' . route('barang.create') . '" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Barang
    </a>'
    ])

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('barang.index') }}" class="form-row">
                <div class="col-md-3 mb-2">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari kode / nama barang..."
                        value="{{ request('keyword') }}">
                </div>
                <div class="col-md-2 mb-2">
                    <select name="category_id" class="form-control">
                        <option value="">-- Semua Kategori --</option>
                        @foreach(\App\Category::orderBy('nama_kategori')->get() as $k)
                        <option value="{{ $k->id }}" {{ request('category_id')==$k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <select name="location_id" class="form-control">
                        <option value="">-- Semua Ruangan --</option>
                        @foreach(\App\Location::orderBy('nama_ruangan')->get() as $r)
                        <option value="{{ $r->id }}" {{ request('location_id')==$r->id ? 'selected' : '' }}>
                            {{ $r->nama_ruangan }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <select name="condition_id" class="form-control">
                        <option value="">-- Semua Kondisi --</option>
                        @foreach(\App\Condition::orderBy('nama_kondisi')->get() as $c)
                        <option value="{{ $c->id }}" {{ request('condition_id')==$c->id ? 'selected' : '' }}>
                            {{ $c->nama_kondisi }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <button class="btn btn-secondary"><i class="fas fa-search"></i> Filter</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-light">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Ruangan</th>
                        <th>Kondisi</th>
                        <th class="text-right">Jumlah</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $d)
                    <tr>
                        <td class="text-center">{{ $data->firstItem() + $i }}</td>
                        <td><span class="badge badge-secondary">{{ $d->kode_barang }}</span></td>
                        <td><strong>{{ $d->nama_barang }}</strong></td>
                        <td>{{ $d->category->nama_kategori ?? '-' }}</td>
                        <td>{{ $d->location->nama_ruangan ?? '-' }}</td>
                        <td>
                            @if(stripos($d->condition->nama_kondisi ?? '', 'baik') !== false)
                            <span class="badge badge-success">{{ $d->condition->nama_kondisi }}</span>
                            @elseif(stripos($d->condition->nama_kondisi ?? '', 'ringan') !== false)
                            <span class="badge badge-warning">{{ $d->condition->nama_kondisi }}</span>
                            @else
                            <span class="badge badge-danger">{{ $d->condition->nama_kondisi ?? '-' }}</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <strong>{{ $d->jumlah }}</strong> {{ $d->satuan }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('barang.show', $d->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('barang.edit', $d->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal" data-action="{{ route('barang.destroy', $d->id) }}"
                                data-message="Hapus barang '{{ $d->nama_barang }}'?" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    @include('partials.empty-state', ['colspan' => 8, 'message' => 'Belum ada data barang.'])
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('partials.pagination-info', ['data' => $data])

</div>
@endsection