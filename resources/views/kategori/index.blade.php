@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Kategori' => route('kategori.index'),
    ]])

    @include('partials.alert')

    @include('partials.page-header', [
    'title' => 'Data Kategori',
    'icon' => 'tags',
    'action' => '<a href="' . route('kategori.create') . '" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>'
    ])

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Nama Kategori</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $d)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $d->nama_kategori }}</td>
                        <td class="text-center">
                            <a href="{{ route('kategori.show', $d->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('kategori.edit', $d->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal" data-action="{{ route('kategori.destroy', $d->id) }}"
                                data-message="Hapus kategori '{{ $d->nama_kategori }}'?" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    @include('partials.empty-state', [
                    'colspan' => 3,
                    'message' => 'Belum ada data kategori.'
                    ])
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('partials.pagination-info', ['data' => $data])
</div>
@endsection