@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header Banner
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">
            Welcome back, <strong>{{ Auth::user()->name ?? 'User' }}</strong> —
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </p>
    </div>
    <a href="{{ route('laporan.inventaris') }}" class="btn-date-picker">
        <i class="bi bi-clipboard-data"></i>
        <span>View Reports</span>
        <i class="bi bi-arrow-right ms-1"></i>
    </a>
</div>
{{-- END: Page Header --}}


{{-- ==========================================
     START: Overdue Loan Alert
     ========================================== --}}
@if($peminjamanTerlambat->count() > 0)
<div class="card alert-green-card mb-4">
    <div class="position-relative z-index-2">
        <span class="alert-green-badge">Warning</span>
        <div class="alert-green-date">{{ $peminjamanTerlambat->count() }} loans</div>
        <div class="alert-green-text">
            {{ $peminjamanTerlambat->count() }} active loans have passed their due date.
        </div>
        <ul class="mb-0 mt-2" style="font-size: 13px;">
            @foreach($peminjamanTerlambat->take(3) as $p)
                <li>
                    <strong>{{ $p->kode_peminjaman }}</strong> —
                    {{ $p->nama_peminjam }} ({{ $p->item->nama_barang ?? '-' }})
                    <span style="color:#dc3545;">
                        (Due: {{ \Carbon\Carbon::parse($p->rencana_kembali)->format('d-m-Y') }})
                    </span>
                </li>
            @endforeach
            @if($peminjamanTerlambat->count() > 3)
                <li><em>... and {{ $peminjamanTerlambat->count() - 3 }} more</em></li>
            @endif
        </ul>
        <a href="{{ route('peminjaman.index', ['status' => 'Dipinjam']) }}"
           class="alert-green-link">
            <span>View All Loans</span>
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <svg class="alert-green-bg-shape" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g transform="translate(50,50)">
            <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" />
            <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(60)" />
            <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(120)" />
        </g>
    </svg>
</div>
@endif
{{-- END: Alert --}}


{{-- ==========================================
     START: Stat Cards
     ========================================== --}}
<div class="row g-4 mb-4">

    {{-- Total Stock --}}
    <div class="col-lg-3 col-md-6">
        <div class="card card-stat d-flex flex-column justify-content-between h-100">
            <div>
                <div class="card-header">
                    <span class="stat-label">Total Stock</span>
                    <i class="bi bi-box-seam" style="font-size: 22px; color: #6366f1;"></i>
                </div>
                <div class="stat-value">{{ number_format($totalBarang) }}</div>
                <div class="trend-badge trend-up">
                    <i class="bi bi-box"></i>
                    <span>{{ $totalJenisBarang }} item types</span>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('barang.index') }}" class="small text-decoration-none">
                    View Details <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Categories --}}
    <div class="col-lg-3 col-md-6">
        <div class="card card-stat d-flex flex-column justify-content-between h-100">
            <div>
                <div class="card-header">
                    <span class="stat-label">Categories</span>
                    <i class="bi bi-tags" style="font-size: 22px; color: #22c55e;"></i>
                </div>
                <div class="stat-value">{{ $totalKategori }}</div>
                <div class="trend-badge trend-up">
                    <i class="bi bi-tag"></i>
                    <span>Active categories</span>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('kategori.index') }}" class="small text-decoration-none">
                    View Details <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Locations --}}
    <div class="col-lg-3 col-md-6">
        <div class="card card-stat d-flex flex-column justify-content-between h-100">
            <div>
                <div class="card-header">
                    <span class="stat-label">Locations</span>
                    <i class="bi bi-door-open" style="font-size: 22px; color: #0ea5e9;"></i>
                </div>
                <div class="stat-value">{{ $totalRuangan }}</div>
                <div class="trend-badge trend-up">
                    <i class="bi bi-geo-alt"></i>
                    <span>Active locations</span>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('ruangan.index') }}" class="small text-decoration-none">
                    View Details <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Active Loans --}}
    <div class="col-lg-3 col-md-6">
        <div class="card card-stat d-flex flex-column justify-content-between h-100">
            <div>
                <div class="card-header">
                    <span class="stat-label">Active Loans</span>
                    <i class="bi bi-hand-index-thumb" style="font-size: 22px; color: #f59e0b;"></i>
                </div>
                <div class="stat-value">{{ $peminjamanAktif }}</div>
                <div class="trend-badge trend-down">
                    <i class="bi bi-clock-history"></i>
                    <span>Items currently borrowed</span>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('peminjaman.index', ['status' => 'Dipinjam']) }}"
                   class="small text-decoration-none">
                    View Details <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

</div>
{{-- END: Stat Cards --}}


{{-- ==========================================
     START: Charts Row 1
     ========================================== --}}
<div class="row g-4 mb-4">

    {{-- Transactions Chart --}}
    <div class="col-lg-8">
        <div class="card h-100 mb-0">
            <div class="card-header">
                <h2 class="card-title">Transaction Trend (Last 7 Days)</h2>
                <div class="d-flex gap-3 align-items-center">
                    <div class="chart-legend-item">
                        <span class="legend-dot" style="background:#B4F105;"></span>
                        <span class="chart-legend-label">Incoming</span>
                    </div>
                    <div class="chart-legend-item">
                        <span class="legend-dot" style="background:#072F1F;"></span>
                        <span class="chart-legend-label">Outgoing</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="chartTransaksi"></div>
            </div>
        </div>
    </div>

    {{-- Items per Category --}}
    <div class="col-lg-4">
        <div class="card h-100 mb-0">
            <div class="card-header">
                <h2 class="card-title">Items per Category</h2>
            </div>
            <div class="card-body">
                <div id="chartKategori"></div>
            </div>
        </div>
    </div>

</div>
{{-- END: Charts Row 1 --}}


{{-- ==========================================
     START: Charts Row 2
     ========================================== --}}
<div class="row g-4 mb-4">

    {{-- Items per Condition --}}
    <div class="col-lg-6">
        <div class="card h-100 mb-0">
            <div class="card-header">
                <h2 class="card-title">Items per Condition</h2>
            </div>
            <div class="card-body">
                <div id="chartKondisi"></div>
            </div>
        </div>
    </div>

    {{-- Items per Location --}}
    <div class="col-lg-6">
        <div class="card h-100 mb-0">
            <div class="card-header">
                <h2 class="card-title">Items per Location</h2>
            </div>
            <div class="card-body">
                <div id="chartRuangan"></div>
            </div>
        </div>
    </div>

</div>
{{-- END: Charts Row 2 --}}


{{-- ==========================================
     START: Recent Activity (3 tables)
     ========================================== --}}
<div class="row g-4 mb-4">

    {{-- Recent Incoming --}}
    <div class="col-lg-4">
        <div class="card h-100 mb-0">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="bi bi-box-arrow-in-down text-primary"></i> Recent Incoming
                </h2>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th class="text-end">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangMasukTerbaru as $b)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($b->tanggal_masuk)->format('d-m') }}</td>
                            <td>{{ Str::limit($b->item->nama_barang ?? '-', 20) }}</td>
                            <td class="text-end">{{ $b->jumlah }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted">No data available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('barang-masuk.index') }}" class="small text-decoration-none">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Outgoing --}}
    <div class="col-lg-4">
        <div class="card h-100 mb-0">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="bi bi-box-arrow-up text-danger"></i> Recent Outgoing
                </h2>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th class="text-end">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangKeluarTerbaru as $b)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($b->tanggal_keluar)->format('d-m') }}</td>
                            <td>{{ Str::limit($b->item->nama_barang ?? '-', 20) }}</td>
                            <td class="text-end">{{ $b->jumlah }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted">No data available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('barang-keluar.index') }}" class="small text-decoration-none">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Loans --}}
    <div class="col-lg-4">
        <div class="card h-100 mb-0">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="bi bi-hand-index-thumb text-warning"></i> Recent Loans
                </h2>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Borrower</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamanTerbaru as $p)
                        <tr>
                            <td>{{ $p->kode_peminjaman }}</td>
                            <td>{{ Str::limit($p->nama_peminjam, 15) }}</td>
                            <td class="text-center">
                                @if($p->status == 'Dipinjam')
                                    <span class="badge bg-warning text-dark">Borrowed</span>
                                @else
                                    <span class="badge bg-success">Returned</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted">No data available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('peminjaman.index') }}" class="small text-decoration-none">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

</div>
{{-- END: Recent Activity --}}


{{-- ==========================================
     START: Low Stock Alert
     ========================================== --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="bi bi-exclamation-circle text-danger"></i>
                    Low Stock Items (≤ 5)
                </h2>
                <span class="badge bg-danger">{{ $stokMenipis->count() }} items</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th class="text-end">Stock</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stokMenipis as $s)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">{{ $s->kode_barang }}</span>
                                </td>
                                <td><strong>{{ $s->nama_barang }}</strong></td>
                                <td>{{ $s->category->nama_kategori ?? '-' }}</td>
                                <td>{{ $s->location->nama_ruangan ?? '-' }}</td>
                                <td class="text-end">
                                    <span class="badge bg-danger">
                                        {{ $s->jumlah }} {{ $s->satuan }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('barang-masuk.create', ['item_id' => $s->id]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-plus-lg"></i> Add Stock
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    <i class="bi bi-check-circle text-success"></i>
                                    All stock levels are safe.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- END: Low Stock --}}

@endsection


@push('scripts')
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       CHART 1: TRANSACTION TREND (AREA / LINE)
    ===================================================== */
    const transaksiData = {
        series: [
            {
                name: 'Incoming',
                data: {!! json_encode($dataMasuk) !!}
            },
            {
                name: 'Outgoing',
                data: {!! json_encode($dataKeluar) !!}
            }
        ],
        chart: {
            type: 'area',
            height: 300,
            fontFamily: 'inherit',
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        colors: ['#B4F105', '#072F1F'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [0, 100]
            }
        },
        stroke: { curve: 'smooth', width: 3 },
        dataLabels: { enabled: false },
        grid: {
            borderColor: '#e9ecef',
            strokeDashArray: 4,
            xaxis: { lines: { show: false } }
        },
        xaxis: {
            categories: {!! json_encode($labels) !!},
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { fontSize: '12px', colors: '#6c757d' } }
        },
        yaxis: {
            labels: { style: { fontSize: '12px', colors: '#6c757d' } }
        },
        legend: { show: false },
        tooltip: {
            shared: true,
            intersect: false,
            y: { formatter: (val) => val + ' items' }
        }
    };
    new ApexCharts(document.querySelector('#chartTransaksi'), transaksiData).render();


    /* =====================================================
       CHART 2: ITEMS PER CATEGORY (DOUGHNUT)
    ===================================================== */
    const kategoriData = {
        series: {!! json_encode($barangPerKategori->pluck('total')) !!},
        labels: {!! json_encode($barangPerKategori->pluck('nama')) !!},
        chart: { type: 'donut', height: 300, fontFamily: 'inherit' },
        colors: [
            '#B4F105', '#072F1F', '#f59e0b', '#ef4444',
            '#0ea5e9', '#8b5cf6', '#f97316', '#14b8a6',
            '#ec4899', '#84cc16'
        ],
        legend: {
            position: 'bottom',
            fontSize: '12px',
            markers: { width: 10, height: 10, radius: 4 }
        },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        name: { fontSize: '12px', color: '#6c757d' },
                        value: {
                            fontSize: '20px',
                            fontWeight: 700,
                            color: '#072F1F',
                            formatter: (val) => val
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '12px',
                            color: '#6c757d',
                            formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                        }
                    }
                }
            }
        },
        tooltip: {
            y: { formatter: (val) => val + ' items' }
        }
    };
    new ApexCharts(document.querySelector('#chartKategori'), kategoriData).render();


    /* =====================================================
       CHART 3: ITEMS PER CONDITION (BAR)
    ===================================================== */
    const kondisiData = {
        series: [{
            name: 'Items',
            data: {!! json_encode($barangPerKondisi->pluck('total')) !!}
        }],
        chart: {
            type: 'bar',
            height: 300,
            fontFamily: 'inherit',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 6,
                columnWidth: '50%',
                distributed: true
            }
        },
        colors: ['#B4F105', '#072F1F', '#ef4444', '#6b7280'],
        dataLabels: { enabled: false },
        grid: {
            borderColor: '#e9ecef',
            strokeDashArray: 4,
            xaxis: { lines: { show: false } }
        },
        xaxis: {
            categories: {!! json_encode($barangPerKondisi->pluck('nama')) !!},
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { fontSize: '12px', colors: '#6c757d' } }
        },
        yaxis: {
            labels: { style: { fontSize: '12px', colors: '#6c757d' } }
        },
        legend: { show: false },
        tooltip: {
            y: { formatter: (val) => val + ' items' }
        }
    };
    new ApexCharts(document.querySelector('#chartKondisi'), kondisiData).render();


    /* =====================================================
       CHART 4: ITEMS PER LOCATION (BAR)
    ===================================================== */
    const ruanganData = {
        series: [{
            name: 'Items',
            data: {!! json_encode($barangPerRuangan->pluck('total')) !!}
        }],
        chart: {
            type: 'bar',
            height: 300,
            fontFamily: 'inherit',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 6,
                columnWidth: '50%',
                horizontal: false
            }
        },
        colors: ['#B4F105'],
        dataLabels: { enabled: false },
        grid: {
            borderColor: '#e9ecef',
            strokeDashArray: 4,
            xaxis: { lines: { show: false } }
        },
        xaxis: {
            categories: {!! json_encode($barangPerRuangan->pluck('nama')) !!},
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { fontSize: '12px', colors: '#6c757d' } }
        },
        yaxis: {
            labels: { style: { fontSize: '12px', colors: '#6c757d' } }
        },
        legend: { show: false },
        tooltip: {
            y: { formatter: (val) => val + ' items' }
        }
    };
    new ApexCharts(document.querySelector('#chartRuangan'), ruanganData).render();

});
</script>
@endpush