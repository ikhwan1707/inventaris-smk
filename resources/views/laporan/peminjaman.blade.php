@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Loan Report</h1>
        <p class="page-subtitle">Complete item loan report</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Reports'     => '#',
        'Loan Report' => route('laporan.peminjaman'),
    ]])
</div>
{{-- END: Page Header --}}


{{-- ==========================================
     START: Filter Card
     ========================================== --}}
<div class="card border-light shadow-sm p-3 mb-3">
    <form method="GET" action="{{ route('laporan.peminjaman') }}">
        <div class="row g-2 align-items-end">

            {{-- Start Date --}}
            <div class="col-12 col-md-2">
                <label class="form-label-custom" style="font-size:12px;">From Date</label>
                <input type="date"
                       name="tanggal_awal"
                       class="form-control-custom"
                       value="{{ request('tanggal_awal') }}">
            </div>

            {{-- End Date --}}
            <div class="col-12 col-md-2">
                <label class="form-label-custom" style="font-size:12px;">To Date</label>
                <input type="date"
                       name="tanggal_akhir"
                       class="form-control-custom"
                       value="{{ request('tanggal_akhir') }}">
            </div>

            {{-- Status --}}
            <div class="col-12 col-md-2">
                <label class="form-label-custom" style="font-size:12px;">Status</label>
                <select name="status" class="form-select-custom">
                    <option value="">-- All --</option>
                    <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Borrowed</option>
                    <option value="Kembali"  {{ request('status') == 'Kembali'  ? 'selected' : '' }}>Returned</option>
                </select>
            </div>

            {{-- Item --}}
            <div class="col-12 col-md-3">
                <label class="form-label-custom" style="font-size:12px;">Item</label>
                <select name="item_id" class="form-select-custom">
                    <option value="">-- All Items --</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->id }}" {{ request('item_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Buttons --}}
            <div class="col-12 col-md-3">
                <button type="submit" class="btn-table-action btn-primary-action">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('laporan.peminjaman') }}" class="btn-table-action">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
                <a href="{{ route('laporan.peminjaman.pdf') . '?' . http_build_query(request()->query()) }}"
                   target="_blank"
                   class="btn-table-action"
                   style="background:#ef4444;color:#fff;">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
            </div>

        </div>
    </form>
</div>
{{-- END: Filter Card --}}


{{-- ==========================================
     START: Report Card
     ========================================== --}}
<div class="table-card-custom">

    {{-- Header Info --}}
    <div class="table-header-control">
        <div>
            <h5 class="card-title mb-0">
                <i class="bi bi-hand-index-thumb text-warning"></i> Loan Transactions
            </h5>
            <span class="text-muted" style="font-size:12px;">
                Showing {{ $data->count() }} loan{{ $data->count() != 1 ? 's' : '' }}
            </span>
        </div>
        <div class="table-filter-group">
            @php
                $totalBorrowed = $data->where('status', 'Dipinjam')->count();
                $totalReturned = $data->where('status', 'Kembali')->count();
            @endphp
            <span class="badge-table pending">
                <i class="bi bi-hourglass-split"></i> Borrowed: {{ $totalBorrowed }}
            </span>
            <span class="badge-table success">
                <i class="bi bi-check-circle-fill"></i> Returned: {{ $totalReturned }}
            </span>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Loan Code</th>
                    <th>Loan Date</th>
                    <th>Item</th>
                    <th>Borrower</th>
                    <th class="text-end">Qty</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                    <th>Condition</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                    @php
                        $terlambat = $d->status == 'Dipinjam'
                            && \Carbon\Carbon::parse($d->rencana_kembali)->isPast();

                        $namaKondisi = $d->return->condition->nama_kondisi ?? null;
                        $badgeClass = 'pending';
                        $statusIcon = 'bi-circle';
                        if ($namaKondisi) {
                            if (stripos($namaKondisi, 'baik') !== false) {
                                $badgeClass = 'success';
                                $statusIcon = 'bi-check-circle-fill';
                            } elseif (stripos($namaKondisi, 'ringan') !== false) {
                                $badgeClass = 'pending';
                                $statusIcon = 'bi-exclamation-triangle-fill';
                            } elseif (stripos($namaKondisi, 'berat') !== false || stripos($namaKondisi, 'rusak') !== false) {
                                $badgeClass = 'failed';
                                $statusIcon = 'bi-x-circle-fill';
                            }
                        }
                    @endphp
                    <tr class="{{ $terlambat ? 'table-danger' : '' }}">
                        <td class="table-order-id">{{ $i + 1 }}</td>
                        <td>
                            <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                {{ $d->kode_peminjaman }}
                            </span>
                        </td>
                        <td>
                            <i class="bi bi-calendar-event text-muted-green"></i>
                            {{ \Carbon\Carbon::parse($d->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td>
                            <div class="table-user-cell">
                                <div class="table-user-avatar"
                                     style="background:#f59e0b;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                    <i class="bi bi-hand-index-thumb"></i>
                                </div>
                                <div>
                                    <div class="table-user-name">{{ $d->item->nama_barang ?? '-' }}</div>
                                    <div class="table-user-sub">
                                        ID: #LOAN-{{ str_pad($d->id, 5, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $d->nama_peminjam }}</strong>
                            @if($d->kelas_atau_unit)
                                <br><small class="text-muted">{{ $d->kelas_atau_unit }}</small>
                            @endif
                        </td>
                        <td class="text-end">
                            <span class="badge-table pending">
                                {{ $d->jumlah }}
                            </span>
                        </td>
                        <td>
                            <i class="bi bi-calendar-check text-muted-green"></i>
                            {{ \Carbon\Carbon::parse($d->rencana_kembali)->format('d M Y') }}
                            @if($terlambat)
                                <br><span class="badge-table failed mt-1">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Overdue
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($d->return)
                                <i class="bi bi-calendar-check text-muted-green"></i>
                                {{ \Carbon\Carbon::parse($d->return->tanggal_kembali)->format('d M Y') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($namaKondisi)
                                <span class="badge-table {{ $badgeClass }}">
                                    <i class="bi {{ $statusIcon }}"></i> {{ $namaKondisi }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($d->status == 'Dipinjam')
                                <span class="badge-table pending">
                                    <i class="bi bi-hourglass-split"></i> Borrowed
                                </span>
                            @else
                                <span class="badge-table success">
                                    <i class="bi bi-check-circle-fill"></i> Returned
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <div class="text-muted-green">
                                <i class="bi bi-inbox" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">No loan data available.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
{{-- END: Report Card --}}

@endsection