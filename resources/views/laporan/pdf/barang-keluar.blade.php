@extends('laporan.pdf.layout', ['judul' => 'Laporan Barang Keluar'])

@section('content')
<table class="data">
    <thead>
        <tr>
            <th width="30">No</th>
            <th width="70">Tanggal</th>
            <th width="80">Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th width="50">Jumlah</th>
            <th width="100">Tujuan</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $i => $d)
        <tr>
            <td align="center">{{ $i + 1 }}</td>
            <td align="center">{{ \Carbon\Carbon::parse($d->tanggal_keluar)->format('d-m-Y') }}</td>
            <td>{{ $d->item->kode_barang ?? '-' }}</td>
            <td>{{ $d->item->nama_barang ?? '-' }}</td>
            <td>{{ $d->item->category->nama_kategori ?? '-' }}</td>
            <td class="text-right">{{ $d->jumlah }}</td>
            <td>{{ $d->tujuan ?? '-' }}</td>
            <td>{{ $d->keterangan ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" align="center">Belum ada data.</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5" style="text-align:right;">Total Jumlah</th>
            <th class="text-right">{{ $total }}</th>
            <th colspan="2"></th>
        </tr>
    </tfoot>
</table>
@endsection