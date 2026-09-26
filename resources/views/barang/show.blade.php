@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Item Detail</h1>
        <p class="page-subtitle">Detailed information of {{ $data->nama_barang }}</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Master Data' => '#',
        'Item'        => route('barang.index'),
        'Detail'      => '',
    ]])
</div>
{{-- END: Page Header --}}


{{-- ==========================================
     START: Alert
     ========================================== --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- END: Alert --}}


{{-- ==========================================
     START: Detail Card
     ========================================== --}}
<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        <div class="card border-light shadow-sm p-4 h-100">

            <h5 class="card-title mb-4">
                <i class="bi bi-info-circle text-primary"></i> Item Information
            </h5>

            @php
                $namaKondisi = strtolower($data->condition->nama_kondisi ?? '');
                $badgeClass = 'failed';
                $statusIcon = 'bi-x-circle-fill';
                $statusLabel = $data->condition->nama_kondisi ?? '-';
                if (strpos($namaKondisi, 'baik') !== false) {
                    $badgeClass = 'success';
                    $statusIcon = 'bi-check-circle-fill';
                } elseif (strpos($namaKondisi, 'ringan') !== false) {
                    $badgeClass = 'pending';
                    $statusIcon = 'bi-exclamation-triangle-fill';
                }
            @endphp

            {{-- Detail Table --}}
            <div class="table-responsive">
                <table class="table-custom">
                    <tbody>
                        <tr>
                            <th width="220" style="background:#f8f9fa;">Item Name</th>
                            <td>
                                <div class="table-user-cell">
                                    <div class="table-user-avatar"
                                         style="background:#6366f1;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <div>
                                        <div class="table-user-name">{{ $data->nama_barang }}</div>
                                        <div class="table-user-sub">
                                            ID: #ITM-{{ str_pad($data->id, 3, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Item Code</th>
                            <td>
                                <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                    {{ $data->kode_barang }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Category</th>
                            <td>{{ $data->category->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Location</th>
                            <td>
                                <i class="bi bi-geo-alt text-muted-green"></i>
                                {{ $data->location->nama_ruangan ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Condition</th>
                            <td>
                                <span class="badge-table {{ $badgeClass }}">
                                    <i class="bi {{ $statusIcon }}"></i> {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Quantity</th>
                            <td>
                                <span class="badge-table success">
                                    {{ $data->jumlah }} {{ $data->satuan }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Procurement Year</th>
                            <td>
                                <i class="bi bi-calendar-event text-muted-green"></i>
                                {{ $data->tahun_pengadaan ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Notes</th>
                            <td>{{ $data->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Created At</th>
                            <td>
                                <i class="bi bi-calendar-plus text-muted-green"></i>
                                {{ $data->created_at->translatedFormat('d F Y, H:i') }} WIB
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Last Updated</th>
                            <td>
                                <i class="bi bi-clock-history text-muted-green"></i>
                                {{ $data->updated_at->translatedFormat('d F Y, H:i') }} WIB
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr class="my-4">

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <a href="{{ route('barang.index') }}" class="btn-table-action">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('barang-masuk.create', ['item_id' => $data->id]) }}"
                       class="btn-table-action"
                       style="background:#22c55e;color:#fff;">
                        <i class="bi bi-plus-lg"></i> Add Stock
                    </a>
                    <a href="{{ route('barang.edit', $data->id) }}"
                       class="btn-table-action btn-primary-action">
                        <i class="bi bi-pencil"></i> Edit Item
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- Side Info Panel --}}
    <div class="col-12 col-lg-4">
        <div class="card border-light shadow-sm p-4 h-100">
            <h5 class="card-title mb-4">
                <i class="bi bi-lightbulb text-warning"></i> Quick Info
            </h5>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#6366f1;">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->jumlah }} {{ $data->satuan }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Current available stock.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#22c55e;">
                        <i class="bi bi-tag-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->category->nama_kategori ?? '-' }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Category classification.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#0ea5e9;">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->location->nama_ruangan ?? '-' }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Stored in this location.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#f59e0b;">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->created_at->diffForHumans() }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Item was first added.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#8b5cf6;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->created_at->diffForHumans() }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Last updated.
                        </div>
                    </div>
                </div>
            </div>

            @if($data->jumlah <= 5)
                <div class="alert alert-warning mb-0" style="font-size: 12px;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Low Stock!</strong> This item has 5 or fewer units remaining.
                </div>
            @endif
        </div>
    </div>
</div>
{{-- END: Detail Card --}}


{{-- ==========================================
     START: Transaction History Card
     ========================================== --}}
<div class="card border-light shadow-sm p-4 mb-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h5 class="card-title mb-0">
            <i class="bi bi-clock-history text-primary"></i> Recent Transactions
        </h5>
        <span class="badge-table success">
            <i class="bi bi-list-ul"></i> Last 10 Records
        </span>
    </div>

    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="120">Date</th>
                    <th width="120">Type</th>
                    <th class="text-end" width="100">Quantity</th>
                    <th>Information</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $riwayat = collect();

                    foreach ($data->itemIns()->latest()->take(10)->get() as $t) {
                        $riwayat->push([
                            'tanggal' => $t->tanggal_masuk,
                            'jenis'   => 'In',
                            'jumlah'  => $t->jumlah,
                            'ket'     => $t->sumber,
                        ]);
                    }
                    foreach ($data->itemOuts()->latest()->take(10)->get() as $t) {
                        $riwayat->push([
                            'tanggal' => $t->tanggal_keluar,
                            'jenis'   => 'Out',
                            'jumlah'  => $t->jumlah,
                            'ket'     => $t->tujuan,
                        ]);
                    }

                    $riwayat = $riwayat->sortByDesc('tanggal')->take(10);
                @endphp

                @forelse($riwayat as $r)
                    <tr>
                        <td>
                            <i class="bi bi-calendar-event text-muted-green"></i>
                            {{ \Carbon\Carbon::parse($r['tanggal'])->translatedFormat('d M Y') }}
                        </td>
                        <td>
                            @if($r['jenis'] == 'In')
                                <span class="badge-table success">
                                    <i class="bi bi-box-arrow-in-down"></i> In
                                </span>
                            @else
                                <span class="badge-table failed">
                                    <i class="bi bi-box-arrow-up"></i> Out
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <strong>{{ $r['jumlah'] }}</strong>
                            <span class="text-muted" style="font-size:12px;">{{ $data->satuan }}</span>
                        </td>
                        <td>{{ $r['ket'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted-green">
                                <i class="bi bi-inbox" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">No transaction history available.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
{{-- END: Transaction History Card --}}

@endsection