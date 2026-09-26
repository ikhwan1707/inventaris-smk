@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Transaksi' => '#',
    'Pengembalian' => route('pengembalian.index'),
    'Detail' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-undo"></i> Detail Pengembalian
                    </span>
                    <span class="badge badge-light">
                        #{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                <div class="card-body">

                    {{-- =====================
                    INFORMASI PENGEMBALIAN
                    ====================== --}}
                    <table class="table table-bordered mb-0">
                        <tr>
                            <th width="220" class="bg-light">Kode Peminjaman</th>
                            <td>
                                <span class="badge badge-secondary">
                                    {{ $data->loan->kode_peminjaman ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Barang</th>
                            <td>
                                <span class="badge badge-secondary">
                                    {{ $data->loan->item->kode_barang ?? '-' }}
                                </span>
                                <strong>{{ $data->loan->item->nama_barang ?? '-' }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Kategori</th>
                            <td>{{ $data->loan->item->category->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Jumlah</th>
                            <td>
                                <span class="badge badge-success">
                                    {{ $data->loan->jumlah ?? 0 }} {{ $data->loan->item->satuan ?? '' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Nama Peminjam</th>
                            <td>
                                <strong>{{ $data->loan->nama_peminjam ?? '-' }}</strong>
                                @if($data->loan->kelas_atau_unit ?? false)
                                <br><small class="text-muted">{{ $data->loan->kelas_atau_unit }}</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tanggal Kembali</th>
                            <td>
                                <i class="far fa-calendar-check text-muted"></i>
                                {{ \Carbon\Carbon::parse($data->tanggal_kembali)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Kondisi Akhir Barang</th>
                            <td>
                                @php
                                $namaKondisi = $data->condition->nama_kondisi ?? '-';
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
                    INFO PEMINJAMAN TERKAIT
                    ====================== --}}
                    <h5 class="mt-4">
                        <i class="fas fa-hand-holding"></i> Informasi Peminjaman Terkait
                    </h5>
                    <table class="table table-bordered table-sm mb-0">
                        <tr>
                            <th width="220" class="bg-light">Tanggal Pinjam</th>
                            <td>
                                <i class="far fa-calendar-alt text-muted"></i>
                                {{ \Carbon\Carbon::parse($data->loan->tanggal_pinjam ?? now())->translatedFormat('d F
                                Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Rencana Kembali</th>
                            <td>
                                <i class="far fa-calendar-check text-muted"></i>
                                {{ \Carbon\Carbon::parse($data->loan->rencana_kembali ?? now())->translatedFormat('d F
                                Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Status Peminjaman</th>
                            <td>
                                @if(($data->loan->status ?? '') == 'Dipinjam')
                                <span class="badge badge-warning">Dipinjam</span>
                                @else
                                <span class="badge badge-success">Kembali</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    {{-- =====================
                    TOMBOL AKSI
                    ====================== --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div>
                            <a href="{{ route('peminjaman.show', $data->loan->id ?? '#') }}" class="btn btn-info">
                                <i class="fas fa-hand-holding"></i> Lihat Peminjaman
                            </a>
                            <a href="{{ route('pengembalian.edit', $data->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#confirmDeleteModal"
                                data-action="{{ route('pengembalian.destroy', $data->id) }}"
                                data-message="Batalkan pengembalian ini? Status peminjaman '{{ $data->loan->kode_peminjaman ?? '-' }}' akan kembali menjadi Dipinjam.">
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