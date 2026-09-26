@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Barang Keluar' => route('barang-keluar.index'),
    'Detail' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-arrow-up"></i> Detail Barang Keluar
                    </span>
                    <span class="badge badge-light">
                        #{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mb-0">
                        <tr>
                            <th width="220" class="bg-light">Tanggal Keluar</th>
                            <td>
                                <i class="far fa-calendar-alt text-muted"></i>
                                {{ \Carbon\Carbon::parse($data->tanggal_keluar)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Kode Barang</th>
                            <td>
                                <span class="badge badge-secondary">
                                    {{ $data->item->kode_barang ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Nama Barang</th>
                            <td><strong>{{ $data->item->nama_barang ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Kategori</th>
                            <td>{{ $data->item->category->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Ruangan / Lokasi</th>
                            <td>{{ $data->item->location->nama_ruangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Jumlah</th>
                            <td>
                                <span class="badge badge-danger">
                                    −{{ $data->jumlah }} {{ $data->item->satuan ?? '' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tujuan</th>
                            <td>{{ $data->tujuan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Keterangan</th>
                            <td>{{ $data->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Dicatat pada</th>
                            <td>
                                <i class="far fa-clock text-muted"></i>
                                {{ $data->created_at->translatedFormat('d F Y, H:i') }} WIB
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Terakhir diperbarui</th>
                            <td>
                                <i class="far fa-clock text-muted"></i>
                                {{ $data->updated_at->translatedFormat('d F Y, H:i') }} WIB
                            </td>
                        </tr>
                    </table>

                    {{-- TOMBOL AKSI --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('barang-keluar.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div>
                            <a href="{{ route('barang-keluar.edit', $data->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal"
                                data-action="{{ route('barang-keluar.destroy', $data->id) }}"
                                data-message="Hapus transaksi ini? Stok barang akan dikembalikan {{ $data->jumlah }} {{ $data->item->satuan ?? '' }}.">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection