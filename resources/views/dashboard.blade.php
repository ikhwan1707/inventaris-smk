@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- ============================
    HEADER
    ============================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Dashboard</h3>
            <small class="text-muted">
                Selamat datang, <strong>{{ Auth::user()->name ?? 'User' }}</strong> —
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </small>
        </div>
        <div>
            <a href="{{ route('laporan.inventaris') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-clipboard-list"></i> Lihat Laporan
            </a>
        </div>
    </div>

    {{-- ============================
    ALERT PEMINJAMAN TERLAMBAT
    ============================= --}}
    @if($peminjamanTerlambat->count() > 0)
    <div class="alert alert-warning">
        <h6 class="mb-1">
            <i class="fas fa-exclamation-triangle"></i>
            Perhatian! Ada {{ $peminjamanTerlambat->count() }} peminjaman yang melewati batas waktu.
        </h6>
        <ul class="mb-0">
            @foreach($peminjamanTerlambat->take(3) as $p)
            <li>
                <strong>{{ $p->kode_peminjaman }}</strong> —
                {{ $p->nama_peminjam }} ({{ $p->item->nama_barang ?? '-' }})
                <span class="text-danger">
                    (Jatuh tempo: {{ \Carbon\Carbon::parse($p->rencana_kembali)->format('d-m-Y') }})
                </span>
            </li>
            @endforeach
            @if($peminjamanTerlambat->count() > 3)
            <li><em>... dan {{ $peminjamanTerlambat->count() - 3 }} lainnya</em></li>
            @endif
        </ul>
        <a href="{{ route('peminjaman.index', ['status' => 'Dipinjam']) }}" class="btn btn-sm btn-warning mt-2">
            Lihat Semua Peminjaman
        </a>
    </div>
    @endif

    {{-- ============================
    KARTU STATISTIK
    ============================= --}}
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Stok Barang</h6>
                            <h2 class="mb-0">{{ number_format($totalBarang) }}</h2>
                            <small>{{ $totalJenisBarang }} jenis barang</small>
                        </div>
                        <i class="fas fa-boxes fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('barang.index') }}" class="text-white small">
                        Lihat Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Kategori</h6>
                            <h2 class="mb-0">{{ $totalKategori }}</h2>
                            <small>&nbsp;</small>
                        </div>
                        <i class="fas fa-tags fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('kategori.index') }}" class="text-white small">
                        Lihat Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-white bg-info h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Ruangan</h6>
                            <h2 class="mb-0">{{ $totalRuangan }}</h2>
                            <small>&nbsp;</small>
                        </div>
                        <i class="fas fa-door-open fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('ruangan.index') }}" class="text-white small">
                        Lihat Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Peminjaman Aktif</h6>
                            <h2 class="mb-0">{{ $peminjamanAktif }}</h2>
                            <small>Barang sedang dipinjam</small>
                        </div>
                        <i class="fas fa-hand-holding fa-3x opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('peminjaman.index', ['status' => 'Dipinjam']) }}" class="text-white small">
                        Lihat Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================
    GRAFIK TRANSAKSI 7 HARI
    ============================= --}}
    <div class="row">
        <div class="col-lg-8 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-chart-line"></i> Grafik Transaksi 7 Hari Terakhir
                </div>
                <div class="card-body">
                    <canvas id="chartTransaksi" height="120"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-chart-pie"></i> Barang per Kategori
                </div>
                <div class="card-body">
                    <canvas id="chartKategori" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Barang per Kondisi --}}
        <div class="col-lg-6 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-chart-bar"></i> Barang per Kondisi
                </div>
                <div class="card-body">
                    <canvas id="chartKondisi" height="150"></canvas>
                </div>
            </div>
        </div>

        {{-- Barang per Ruangan --}}
        <div class="col-lg-6 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-chart-bar"></i> Barang per Ruangan
                </div>
                <div class="card-body">
                    <canvas id="chartRuangan" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================
    AKTIVITAS TERBARU
    ============================= --}}
    <div class="row">
        {{-- Barang Masuk Terbaru --}}
        <div class="col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-arrow-down"></i> Barang Masuk Terbaru
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th class="text-right">Jml</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangMasukTerbaru as $b)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($b->tanggal_masuk)->format('d-m') }}</td>
                                <td>{{ Str::limit($b->item->nama_barang ?? '-', 20) }}</td>
                                <td class="text-right">{{ $b->jumlah }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('barang-masuk.index') }}" class="small">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Barang Keluar Terbaru --}}
        <div class="col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-arrow-up"></i> Barang Keluar Terbaru
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th class="text-right">Jml</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangKeluarTerbaru as $b)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($b->tanggal_keluar)->format('d-m') }}</td>
                                <td>{{ Str::limit($b->item->nama_barang ?? '-', 20) }}</td>
                                <td class="text-right">{{ $b->jumlah }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('barang-keluar.index') }}" class="small">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Peminjaman Terbaru --}}
        <div class="col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-hand-holding"></i> Peminjaman Terbaru
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Peminjam</th>
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
                                    <span class="badge badge-warning">Dipinjam</span>
                                    @else
                                    <span class="badge badge-success">Kembali</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('peminjaman.index') }}" class="small">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================
    STOK MENIPIS
    ============================= --}}
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-exclamation-circle"></i> Barang dengan Stok Menipis (≤ 5)
                    <span class="badge badge-light float-right">{{ $stokMenipis->count() }} barang</span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Ruangan</th>
                                <th class="text-right">Stok</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stokMenipis as $s)
                            <tr>
                                <td>{{ $s->kode_barang }}</td>
                                <td>{{ $s->nama_barang }}</td>
                                <td>{{ $s->category->nama_kategori ?? '-' }}</td>
                                <td>{{ $s->location->nama_ruangan ?? '-' }}</td>
                                <td class="text-right">
                                    <span class="badge badge-danger">
                                        {{ $s->jumlah }} {{ $s->satuan }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('barang-masuk.create', ['item_id' => $s->id]) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-plus"></i> Tambah Stok
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Semua stok barang aman.
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    /* =====================================================
       CHART 1: TRANSAKSI 7 HARI (LINE)
    ===================================================== */
    const ctxTransaksi = document.getElementById('chartTransaksi').getContext('2d');
    new Chart(ctxTransaksi, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Barang Masuk',
                    data: {!! json_encode($dataMasuk) !!},
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'Barang Keluar',
                    data: {!! json_encode($dataKeluar) !!},
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    fill: true,
                    tension: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    /* =====================================================
       CHART 2: BARANG PER KATEGORI (DOUGHNUT)
    ===================================================== */
    const ctxKategori = document.getElementById('chartKategori').getContext('2d');
    new Chart(ctxKategori, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($barangPerKategori->pluck('nama')) !!},
            datasets: [{
                data: {!! json_encode($barangPerKategori->pluck('total')) !!},
                backgroundColor: [
                    '#007bff', '#28a745', '#ffc107', '#dc3545',
                    '#17a2b8', '#6f42c1', '#fd7e14', '#20c997',
                    '#e83e8c', '#6610f2'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 10 } } }
            }
        }
    });

    /* =====================================================
       CHART 3: BARANG PER KONDISI (BAR)
    ===================================================== */
    const ctxKondisi = document.getElementById('chartKondisi').getContext('2d');
    new Chart(ctxKondisi, {
        type: 'bar',
        data: {
            labels: {!! json_encode($barangPerKondisi->pluck('nama')) !!},
            datasets: [{
                label: 'Jumlah Barang',
                data: {!! json_encode($barangPerKondisi->pluck('total')) !!},
                backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    /* =====================================================
       CHART 4: BARANG PER RUANGAN (BAR)
    ===================================================== */
    const ctxRuangan = document.getElementById('chartRuangan').getContext('2d');
    new Chart(ctxRuangan, {
        type: 'bar',
        data: {
            labels: {!! json_encode($barangPerRuangan->pluck('nama')) !!},
            datasets: [{
                label: 'Jumlah Barang',
                data: {!! json_encode($barangPerRuangan->pluck('total')) !!},
                backgroundColor: '#17a2b8'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endpush