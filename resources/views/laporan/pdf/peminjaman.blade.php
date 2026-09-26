@extends('laporan.pdf.layout', ['judul' => 'Laporan Peminjaman Barang'])

@section('content')
<table class="data">
    <thead>
        <tr>
            <th width="25">No</th>
            <th width="70">Kode</th>
            <th width="55">Tgl Pinjam</th>
            <th>Barang</th>
            <th>Peminjam</th>
            <th width="35">Jml</th>
            <th width="55">Rencana Kembali</th>
            <th width="55">Tgl Kembali</th>
            <th width="55">Kondisi</th>
            <th width="50">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $i => $d)
        <tr>
            <td align="center">{{ $i + 1 }}</td>
            <td>{{ $d->kode_peminjaman }}</td>
            <td align="center">{{ \Carbon\Carbon::parse($d->tanggal_pinjam)->format('d-m-Y') }}</td>
            <td>{{ $d->item->nama_barang ?? '-' }}</td>
            <td>{{ $d->nama_peminjam }}</td>
            <td class="text-right">{{ $d->jumlah }}</td>
            <td align="center">{{ \Carbon\Carbon::parse($d->rencana_kembali)->format('d-m-Y') }}</td>
            <td align="center">
                @if($d->return)
                {{ \Carbon\Carbon::parse($d->return->tanggal_kembali)->format('d-m-Y') }}
                @else
                -
                @endif
            </td>
            <td>{{ $d->return->condition->nama_kondisi ?? '-' }}</td>
            <td align="center">{{ $d->status }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="10" align="center">Belum ada data.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection