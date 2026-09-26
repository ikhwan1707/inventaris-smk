<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventaris SMK') }}</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div id="app">
        {{-- ==================== NAVBAR ==================== --}}
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">

                {{-- Logo / Brand --}}
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="fas fa-boxes"></i> Inventaris SMK
                </a>

                {{-- Toggle untuk mobile --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    {{-- ===== MENU KIRI ===== --}}
                    <ul class="navbar-nav mr-auto">

                        {{-- 1. DASHBOARD --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>

                        {{-- 2. MASTER DATA --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle
                            {{ request()->routeIs('kategori.*','ruangan.*','kondisi.*','barang.*') ? 'active' : '' }}"
                                href="#" id="masterDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-database"></i> Master Data
                            </a>
                            <div class="dropdown-menu" aria-labelledby="masterDropdown">
                                <a class="dropdown-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}"
                                    href="{{ route('kategori.index') }}">
                                    <i class="fas fa-tags"></i> Kategori
                                </a>
                                <a class="dropdown-item {{ request()->routeIs('ruangan.*') ? 'active' : '' }}"
                                    href="{{ route('ruangan.index') }}">
                                    <i class="fas fa-door-open"></i> Ruangan/Lokasi
                                </a>
                                <a class="dropdown-item {{ request()->routeIs('kondisi.*') ? 'active' : '' }}"
                                    href="{{ route('kondisi.index') }}">
                                    <i class="fas fa-clipboard-check"></i> Kondisi
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ request()->routeIs('barang.*') ? 'active' : '' }}"
                                    href="{{ route('barang.index') }}">
                                    <i class="fas fa-box"></i> Barang
                                </a>
                            </div>
                        </li>

                        {{-- 3. TRANSAKSI --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle
                            {{ request()->routeIs('barang-masuk.*','barang-keluar.*','peminjaman.*','pengembalian.*') ? 'active' : '' }}"
                                href="#" id="transaksiDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-exchange-alt"></i> Transaksi
                            </a>
                            <div class="dropdown-menu" aria-labelledby="transaksiDropdown">
                                <a class="dropdown-item {{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}"
                                    href="{{ route('barang-masuk.index') }}">
                                    <i class="fas fa-arrow-down"></i> Barang Masuk
                                </a>
                                <a class="dropdown-item {{ request()->routeIs('barang-keluar.*') ? 'active' : '' }}"
                                    href="{{ route('barang-keluar.index') }}">
                                    <i class="fas fa-arrow-up"></i> Barang Keluar
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}"
                                    href="{{ route('peminjaman.index') }}">
                                    <i class="fas fa-hand-holding"></i> Peminjaman
                                </a>
                                <a class="dropdown-item {{ request()->routeIs('pengembalian.*') ? 'active' : '' }}"
                                    href="{{ route('pengembalian.index') }}">
                                    <i class="fas fa-undo"></i> Pengembalian
                                </a>
                            </div>
                        </li>

                        {{-- 4. LAPORAN --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
                                href="#" id="laporanDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-file-alt"></i> Laporan
                            </a>
                            <div class="dropdown-menu" aria-labelledby="laporanDropdown">
                                <a class="dropdown-item {{ request()->routeIs('laporan.inventaris') ? 'active' : '' }}"
                                    href="{{ route('laporan.inventaris') }}">
                                    <i class="fas fa-clipboard-list"></i> Laporan Inventaris
                                </a>
                                <a class="dropdown-item {{ request()->routeIs('laporan.barang-masuk') ? 'active' : '' }}"
                                    href="{{ route('laporan.barang-masuk') }}">
                                    <i class="fas fa-arrow-down"></i> Laporan Barang Masuk
                                </a>
                                <a class="dropdown-item {{ request()->routeIs('laporan.barang-keluar') ? 'active' : '' }}"
                                    href="{{ route('laporan.barang-keluar') }}">
                                    <i class="fas fa-arrow-up"></i> Laporan Barang Keluar
                                </a>
                                <a class="dropdown-item {{ request()->routeIs('laporan.peminjaman') ? 'active' : '' }}"
                                    href="{{ route('laporan.peminjaman') }}">
                                    <i class="fas fa-hand-holding"></i> Laporan Peminjaman
                                </a>
                            </div>
                        </li>


                    </ul>

                    {{-- ===== MENU KANAN: USER ===== --}}
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name ?? 'User' }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('user.index') }}">
                                    <i class="fas fa-users"></i> Pengaturan User
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>

        {{-- ==================== KONTEN ==================== --}}
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    @include('partials.confirm-delete-modal')
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>