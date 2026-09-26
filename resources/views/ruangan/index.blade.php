@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Ruangan' => route('ruangan.index'),
    ]])

    @include('partials.alert')

    @include('partials.page-header', [
    'title' => 'Data Ruangan / Lokasi',
    'icon' => 'door-open',
    'action' => '<a href="' . route('ruangan.create') . '" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Ruangan
    </a>'
    ])

    {{-- TABEL --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Nama Ruangan</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $d)
                    <tr>
                        <td class="text-center">{{ $data->firstItem() + $i }}</td>
                        <td>{{ $d->nama_ruangan }}</td>
                        <td class="text-center">
                            <a href="{{ route('ruangan.show', $d->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('ruangan.edit', $d->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal" data-action="{{ route('ruangan.destroy', $d->id) }}"
                                data-message="Hapus ruangan '{{ $d->nama_ruangan }}'?" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    @include('partials.empty-state', [
                    'colspan' => 3,
                    'message' => 'Belum ada data ruangan.'
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