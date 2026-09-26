@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Peminjaman' => route('peminjaman.index'),
    'Detail' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-hand-holding"></i>
                        Detail Peminjaman
                    </span>
                    <div>
                        @if($data->status == 'Dipinjam')
                        <span class="badge badge-warning">Dipinjam</span>
                        @else
                        <span class="badge badge-success">Kembali</span>
                        @endif
                        <span class="badge badge-light">
                            {{ $data->kode_peminjaman }}
                        </span>
                    </div>
                </div>
                <div class="card-body">

                    {{-- =====================
                    INFORMASI PEMINJAMAN
                    ====================== --}}
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th width="220" class="bg-light">Kode Peminjaman</th>
                            <td>
                                <span class="badge badge-secondary">{{ $data->kode_peminjaman }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Status</th>
                            <td>
                                @if($data->status == 'Dipinjam')
                                <span class="badge badge-warning">Dipinjam</span>
                                @else
                                <span class="badge badge-success">Kembali</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Barang</th>
                            <td>
                                <span class="badge badge-secondary">
                                    {{ $data->item->kode_barang ?? '-' }}
                                </span>
                                <strong>{{ $data->item->nama_barang ?? '-' }}</strong>
                            </td>
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
                            <th class="bg-light">Jumlah Dipinjam</th>
                            <td>
                                <span class="badge badge-info">
                                    {{ $data->jumlah }} {{ $data->item->satuan ?? '' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Nama Peminjam</th>
                            <td><strong>{{ $data->nama_peminjam }}</strong></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Kelas / Unit</th>
                            <td>{{ $data->kelas_atau_unit ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tanggal Pinjam</th>
                            <td>
                                <i class="far fa-calendar-alt text-muted"></i>
                                {{ \Carbon\Carbon::parse($data->tanggal_pinjam)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Rencana Kembali</th>
                            <td>
                                <i class="far fa-calendar-check text-muted"></i>
                                {{ \Carbon\Carbon::parse($data->rencana_kembali)->translatedFormat('d F Y') }}

                                @php
                                $terlambat = $data->status == 'Dipinjam'
                                && \Carbon\Carbon::parse($data->rencana_kembali)->isPast();
                                @endphp

                                @if($terlambat)
                                <span class="badge badge-danger ml-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Terlambat
                                    ({{ \Carbon\Carbon::parse($data->rencana_kembali)->diffForHumans() }})
                                </span>
                                @endif
                            </td>
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

                    {{-- =====================
                    RIWAYAT PENGEMBALIAN
                    ====================== --}}
                    @if($data->returns->count() > 0)
                    <h5 class="mt-4">
                        <i class="fas fa-history"></i> Riwayat Pengembalian
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50" class="text-center">No</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Kondisi Akhir</th>
                                    <th>Keterangan</th>
                                    <th>Dicatat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->returns as $i => $r)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>
                                        <i class="far fa-calendar-check text-muted"></i>
                                        {{ \Carbon\Carbon::parse($r->tanggal_kembali)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>
                                        @php
                                        $namaKondisi = $r->condition->nama_kondisi ?? '-';
                                        $badgeClass = 'badge-secondary';
                                        if (stripos($namaKondisi, 'baik') !== false) {
                                        $badgeClass = 'badge-success';
                                        } elseif (stripos($namaKondisi, 'ringan') !== false) {
                                        $badgeClass = 'badge-warning';
                                        } elseif (stripos($namaKondisi, 'berat') !== false || stripos($namaKondisi,
                                        'rusak') !== false) {
                                        $badgeClass = 'badge-danger';
                                        }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ $namaKondisi }}
                                        </span>
                                    </td>
                                    <td>{{ $r->keterangan ?? '-' }}</td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $r->created_at->translatedFormat('d F Y, H:i') }} WIB
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-secondary mt-4 mb-0">
                        <i class="fas fa-info-circle"></i>
                        Belum ada riwayat pengembalian untuk peminjaman ini.
                    </div>
                    @endif

                    {{-- =====================
                    TOMBOL AKSI
                    ====================== --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div>
                            @if($data->status == 'Dipinjam')
                            <a href="{{ route('pengembalian.create', ['loan_id' => $data->id]) }}"
                                class="btn btn-success">
                                <i class="fas fa-undo"></i> Proses Pengembalian
                            </a>
                            <a href="{{ route('peminjaman.edit', $data->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal"
                                data-action="{{ route('peminjaman.destroy', $data->id) }}"
                                data-message="Hapus peminjaman '{{ $data->kode_peminjaman }}'? Stok barang akan dikembalikan {{ $data->jumlah }} {{ $data->item->satuan ?? '' }}.">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection