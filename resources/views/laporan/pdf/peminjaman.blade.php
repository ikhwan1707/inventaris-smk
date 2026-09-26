@extends('laporan.pdf.layout', ['judul' => 'Loan Report'])

@section('content')
<table class="data">
    <thead>
        <tr>
            <th width="25">No</th>
            <th width="75">Loan Code</th>
            <th width="55">Loan Date</th>
            <th>Item</th>
            <th>Borrower</th>
            <th width="35">Qty</th>
            <th width="55">Due Date</th>
            <th width="55">Return Date</th>
            <th width="55">Condition</th>
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
                        —
                    @endif
                </td>
                <td>{{ $d->return->condition->nama_kondisi ?? '—' }}</td>
                <td align="center">
                    @if($d->status == 'Dipinjam')
                        Borrowed
                    @else
                        Returned
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" align="center">No loan data available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection