@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Pengaturan' => '#',
    'User' => route('user.index'),
    ]])

    @include('partials.alert')

    @include('partials.page-header', [
    'title' => 'Pengaturan User',
    'icon' => 'users',
    'action' => '<a href="' . route('user.create') . '" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah User
    </a>'
    ])


    {{-- TABEL --}}
    <div class="card">
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Terdaftar</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $d)
                    <tr>
                        <td class="text-center">{{ $data->firstItem() + $i }}</td>
                        <td>
                            <i class="fas fa-user-circle text-muted"></i>
                            <strong>{{ $d->name }}</strong>
                            @if($d->id == auth()->id())
                            <span class="badge badge-info ml-1">Anda</span>
                            @endif
                        </td>
                        <td>
                            <i class="fas fa-envelope text-muted"></i>
                            {{ $d->email }}
                        </td>
                        <td>
                            <i class="far fa-clock text-muted"></i>
                            {{ $d->created_at->translatedFormat('d F Y') }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('user.show', $d->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('user.edit', $d->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($d->id != auth()->id())
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal" data-action="{{ route('user.destroy', $d->id) }}"
                                data-message="Hapus user '{{ $d->name }}'? Tindakan ini tidak dapat dibatalkan."
                                title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    @include('partials.empty-state', [
                    'colspan' => 5,
                    'message' => 'Belum ada user terdaftar.'
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