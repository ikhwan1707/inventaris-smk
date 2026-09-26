@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Kondisi' => route('kondisi.index'),
    ]])

    @include('partials.alert')

    @include('partials.page-header', [
    'title' => 'Data Kondisi Barang',
    'icon' => 'clipboard-check',
    'action' => '<a href="' . route('kondisi.create') . '" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Kondisi
    </a>'
    ])

    {{-- TABEL --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Nama Kondisi</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $d)
                    <tr>
                        <td class="text-center">{{ $data->firstItem() + $i }}</td>
                        <td>
                            @if(stripos($d->nama_kondisi, 'baik') !== false)
                            <span class="badge badge-success">{{ $d->nama_kondisi }}</span>
                            @elseif(stripos($d->nama_kondisi, 'ringan') !== false)
                            <span class="badge badge-warning">{{ $d->nama_kondisi }}</span>
                            @elseif(stripos($d->nama_kondisi, 'berat') !== false || stripos($d->nama_kondisi, 'rusak')
                            !== false)
                            <span class="badge badge-danger">{{ $d->nama_kondisi }}</span>
                            @else
                            {{ $d->nama_kondisi }}
                            @endif
                        </td>
                        <td class="text-center">
                           
                            <a href="{{ route('kondisi.edit', $d->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal" data-action="{{ route('kondisi.destroy', $d->id) }}"
                                data-message="Hapus kondisi '{{ $d->nama_kondisi }}'?" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    @include('partials.empty-state', [
                    'colspan' => 3,
                    'message' => 'Belum ada data kondisi barang.'
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