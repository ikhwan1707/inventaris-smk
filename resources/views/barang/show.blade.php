@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Barang' => route('barang.index'),
    'Detail' => '',
    ]])

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-box"></i> Detail Barang: {{ $data->nama_barang }}
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Kode Barang</th>
                            <td>{{ $data->kode_barang }}</td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $data->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $data->category->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Ruangan</th>
                            <td>{{ $data->location->nama_ruangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kondisi</th>
                            <td>{{ $data->condition->nama_kondisi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td><strong>{{ $data->jumlah }}</strong> {{ $data->satuan }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Pengadaan</th>
                            <td>{{ $data->tahun_pengadaan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $data->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $data->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diperbarui</th>
                            <td>{{ $data->updated_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="mb-3">
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('barang.edit', $data->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('barang-masuk.create', ['item_id' => $data->id]) }}" class="btn btn-success">
                            <i class="fas fa-arrow-down"></i> Tambah Stok
                        </a>
                    </div>

                    {{-- Riwayat Transaksi --}}
                    <h5 class="mt-4">Riwayat 10 Transaksi Terakhir</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th class="text-right">Jumlah</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $riwayat = collect();
                                foreach ($data->itemIns()->latest()->take(10)->get() as $t) {
                                $riwayat->push(['tanggal' => $t->tanggal_masuk, 'jenis' => 'Masuk', 'jumlah' =>
                                $t->jumlah, 'ket' => $t->sumber]);
                                }
                                foreach ($data->itemOuts()->latest()->take(10)->get() as $t) {
                                $riwayat->push(['tanggal' => $t->tanggal_keluar, 'jenis' => 'Keluar', 'jumlah' =>
                                $t->jumlah, 'ket' => $t->tujuan]);
                                }
                                $riwayat = $riwayat->sortByDesc('tanggal')->take(10);
                                @endphp
                                @forelse($riwayat as $r)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($r['tanggal'])->format('d-m-Y') }}</td>
                                    <td>
                                        @if($r['jenis'] == 'Masuk')
                                        <span class="badge badge-success">Masuk</span>
                                        @else
                                        <span class="badge badge-danger">Keluar</span>
                                        @endif
                                    </td>
                                    <td class="text-right">{{ $r['jumlah'] }}</td>
                                    <td>{{ $r['ket'] ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection