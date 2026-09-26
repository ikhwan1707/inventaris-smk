@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Outgoing Report</h1>
        <p class="page-subtitle">Complete outgoing transaction report</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Reports'         => '#',
        'Outgoing Report' => route('laporan.barang-keluar'),
    ]])
</div>
{{-- END: Page Header --}}


{{-- ==========================================
     START: Filter Card
     ========================================== --}}
<div class="card border-light shadow-sm p-3 mb-3">
    <form method="GET" action="{{ route('laporan.barang-keluar') }}">
        <div class="row g-2 align-items-end">

            {{-- Start Date --}}
            <div class="col-12 col-md-3">
                <label class="form-label-custom" style="font-size:12px;">From Date</label>
                <input type="date"
                       name="tanggal_awal"
                       class="form-control-custom"
                       value="{{ request('tanggal_awal') }}">
            </div>

            {{-- End Date --}}
            <div class="col-12 col-md-3">
                <label class="form-label-custom" style="font-size:12px;">To Date</label>
                <input type="date"
                       name="tanggal_akhir"
                       class="form-control-custom"
                       value="{{ request('tanggal_akhir') }}">
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
                <a href="{{ route('laporan.barang-keluar') }}" class="btn-table-action">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
                <a href="{{ route('laporan.barang-keluar.pdf') . '?' . http_build_query(request()->query()) }}"
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
                <i class="bi bi-box-arrow-up text-danger"></i> Outgoing Transactions
            </h5>
            <span class="text-muted" style="font-size:12px;">
                Showing {{ $data->count() }} transaction{{ $data->count() != 1 ? 's' : '' }}
            </span>
        </div>
        <div class="table-filter-group">
            <span class="badge-table failed">
                <i class="bi bi-dash-circle"></i> Total Out: {{ $total }} units
            </span>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Date</th>
                    <th>Code</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th class="text-end">Quantity</th>
                    <th>Destination</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                    <tr>
                        <td class="table-order-id">{{ $i + 1 }}</td>
                        <td>
                            <i class="bi bi-calendar-event text-muted-green"></i>
                            {{ \Carbon\Carbon::parse($d->tanggal_keluar)->format('d M Y') }}
                        </td>
                        <td>
                            <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                {{ $d->item->kode_barang ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="table-user-cell">
                                <div class="table-user-avatar"
                                     style="background:#ef4444;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                    <i class="bi bi-box-arrow-up"></i>
                                </div>
                                <div>
                                    <div class="table-user-name">{{ $d->item->nama_barang ?? '-' }}</div>
                                    <div class="table-user-sub">
                                        ID: #OUT-{{ str_pad($d->id, 5, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $d->item->category->nama_kategori ?? '-' }}</td>
                        <td class="text-end">
                            <span class="badge-table failed">
                                <i class="bi bi-dash-lg"></i> {{ $d->jumlah }}
                            </span>
                        </td>
                        <td>{{ $d->tujuan ?? '-' }}</td>
                        <td>{{ $d->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted-green">
                                <i class="bi bi-inbox" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">No outgoing transaction data available.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($data->count() > 0)
                <tfoot>
                    <tr style="background:#f8f9fa;">
                        <th colspan="5" class="text-end" style="padding-right:15px;">
                            <strong>Total Quantity</strong>
                        </th>
                        <th class="text-end">
                            <span class="badge-table failed" style="font-size: 13px;">
                                −{{ $total }}
                            </span>
                        </th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

</div>
{{-- END: Report Card --}}

@endsection