@extends('laporan.pdf.layout', ['judul' => 'Laporan Inventaris Barang'])

@section('content')
<table class="data">
    <thead>
        <tr>
            <th width="30">No</th>
            <th width="70">Kode</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Ruangan</th>
            <th>Kondisi</th>
            <th width="50">Jumlah</th>
            <th width="55">Satuan</th>
            <th width="45">Tahun</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $i => $d)
        <tr>
            <td align="center">{{ $i + 1 }}</td>
            <td>{{ $d->kode_barang }}</td>
            <td>{{ $d->nama_barang }}</td>
            <td>{{ $d->category->nama_kategori ?? '-' }}</td>
            <td>{{ $d->location->nama_ruangan ?? '-' }}</td>
            <td>{{ $d->condition->nama_kondisi ?? '-' }}</td>
            <td class="text-right">{{ $d->jumlah }}</td>
            <td>{{ $d->satuan }}</td>
            <td align="center">{{ $d->tahun_pengadaan ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="9" align="center">Belum ada data.</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align:right;">Total Jumlah</th>
            <th class="text-right">{{ $totalJumlah }}</th>
            <th colspan="2"></th>
        </tr>
    </tfoot>
</table>
@endsection