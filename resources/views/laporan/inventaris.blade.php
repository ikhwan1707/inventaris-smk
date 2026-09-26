@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Inventory Report</h1>
        <p class="page-subtitle">Complete inventory report of all items</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Reports'          => '#',
        'Inventory Report' => route('laporan.inventaris'),
    ]])
</div>
{{-- END: Page Header --}}


{{-- ==========================================
     START: Filter Card
     ========================================== --}}
<div class="card border-light shadow-sm p-3 mb-3">
    <form method="GET" action="{{ route('laporan.inventaris') }}">
        <div class="row g-2 align-items-end">

            {{-- Category --}}
            <div class="col-12 col-md-2">
                <label class="form-label-custom" style="font-size:12px;">Category</label>
                <select name="category_id" class="form-select-custom">
                    <option value="">-- All --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ request('category_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Location --}}
            <div class="col-12 col-md-2">
                <label class="form-label-custom" style="font-size:12px;">Location</label>
                <select name="location_id" class="form-select-custom">
                    <option value="">-- All --</option>
                    @foreach($ruangan as $r)
                        <option value="{{ $r->id }}" {{ request('location_id') == $r->id ? 'selected' : '' }}>
                            {{ $r->nama_ruangan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Condition --}}
            <div class="col-12 col-md-2">
                <label class="form-label-custom" style="font-size:12px;">Condition</label>
                <select name="condition_id" class="form-select-custom">
                    <option value="">-- All --</option>
                    @foreach($kondisi as $c)
                        <option value="{{ $c->id }}" {{ request('condition_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->nama_kondisi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Keyword --}}
            <div class="col-12 col-md-3">
                <label class="form-label-custom" style="font-size:12px;">Search</label>
                <input type="text"
                       name="keyword"
                       class="form-control-custom"
                       placeholder="Search code or name..."
                       value="{{ request('keyword') }}">
            </div>

            {{-- Buttons --}}
            <div class="col-12 col-md-3">
                <button type="submit" class="btn-table-action btn-primary-action">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('laporan.inventaris') }}" class="btn-table-action">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
                <a href="{{ route('laporan.inventaris.pdf') . '?' . http_build_query(request()->query()) }}"
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
                <i class="bi bi-clipboard-data text-primary"></i> Inventory Items
            </h5>
            <span class="text-muted" style="font-size:12px;">
                Showing {{ $data->count() }} item{{ $data->count() != 1 ? 's' : '' }}
            </span>
        </div>
        <div class="table-filter-group">
            <span class="badge-table success">
                <i class="bi bi-box-seam"></i> Total: {{ $totalJumlah }} units
            </span>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Code</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Condition</th>
                    <th class="text-end">Quantity</th>
                    <th>Unit</th>
                    <th class="text-center">Year</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                    @php
                        $namaKondisi = strtolower($d->condition->nama_kondisi ?? '');
                        $badgeClass = 'failed';
                        $statusIcon = 'bi-x-circle-fill';
                        $statusLabel = $d->condition->nama_kondisi ?? '-';
                        if (strpos($namaKondisi, 'baik') !== false) {
                            $badgeClass = 'success';
                            $statusIcon = 'bi-check-circle-fill';
                        } elseif (strpos($namaKondisi, 'ringan') !== false) {
                            $badgeClass = 'pending';
                            $statusIcon = 'bi-exclamation-triangle-fill';
                        }
                    @endphp
                    <tr>
                        <td class="table-order-id">{{ $i + 1 }}</td>
                        <td>
                            <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                {{ $d->kode_barang }}
                            </span>
                        </td>
                        <td>
                            <div class="table-user-cell">
                                <div class="table-user-avatar"
                                     style="background:#6366f1;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div>
                                    <div class="table-user-name">{{ $d->nama_barang }}</div>
                                    <div class="table-user-sub">
                                        ID: #ITM-{{ str_pad($d->id, 3, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $d->category->nama_kategori ?? '-' }}</td>
                        <td>
                            <i class="bi bi-geo-alt text-muted-green"></i>
                            {{ $d->location->nama_ruangan ?? '-' }}
                        </td>
                        <td>
                            <span class="badge-table {{ $badgeClass }}">
                                <i class="bi {{ $statusIcon }}"></i> {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="text-end">
                            <strong>{{ $d->jumlah }}</strong>
                        </td>
                        <td>{{ $d->satuan }}</td>
                        <td class="text-center">
                            <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                {{ $d->tahun_pengadaan ?? '-' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <div class="text-muted-green">
                                <i class="bi bi-inbox" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">No inventory data available.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($data->count() > 0)
                <tfoot>
                    <tr style="background:#f8f9fa;">
                        <th colspan="6" class="text-end" style="padding-right:15px;">
                            <strong>Total Quantity</strong>
                        </th>
                        <th class="text-end">
                            <span class="badge-table success" style="font-size: 13px;">
                                {{ $totalJumlah }}
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