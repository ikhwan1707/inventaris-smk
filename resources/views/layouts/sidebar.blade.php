<div class="sidebar-wrapper" id="sidebar">
        <!-- Brand Logo / Identity -->
        <a href="/dashboard" class="sidebar-brand">
            <i class="bi bi-asterisk"></i>
            <span>Inventaris</span>
        </a>

        <!-- Navigation Menu -->
        <div class="flex-grow-1 overflow-y-auto">
            <!-- Group: Menu -->
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Menu</div>
                <ul class="sidebar-menu-list">
                    <li class="sidebar-menu-item">
                        <a href="/dashboard" class="sidebar-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" id="menu-overview" title="Overview">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Group: Components -->
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Master Data</div>
                <ul class="sidebar-menu-list">

                    <li class="sidebar-menu-item">
                        <a href="{{ route('kategori.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}"
                        id="menu-kategori"
                        title="Kategori">
                            <i class="bi bi-tags"></i>
                            <span>Kategori</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('ruangan.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('ruangan.*') ? 'active' : '' }}"
                        id="menu-ruangan"
                        title="Ruangan / Lokasi">
                            <i class="bi bi-door-open"></i>
                            <span>Ruangan/Lokasi</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('kondisi.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('kondisi.*') ? 'active' : '' }}"
                        id="menu-kondisi"
                        title="Kondisi Barang">
                            <i class="bi bi-clipboard-check"></i>
                            <span>Kondisi</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('barang.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('barang.*') ? 'active' : '' }}"
                        id="menu-barang"
                        title="Data Barang">
                            <i class="bi bi-box-seam"></i>
                            <span>Barang</span>
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Group: Pages -->
           <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Transaksi</div>
                <ul class="sidebar-menu-list">

                    <li class="sidebar-menu-item">
                        <a href="{{ route('barang-masuk.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}"
                        id="menu-barang-masuk"
                        title="Barang Masuk">
                            <i class="bi bi-box-arrow-in-down"></i>
                            <span>Barang Masuk</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('barang-keluar.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('barang-keluar.*') ? 'active' : '' }}"
                        id="menu-barang-keluar"
                        title="Barang Keluar">
                            <i class="bi bi-box-arrow-up"></i>
                            <span>Barang Keluar</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('peminjaman.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}"
                        id="menu-peminjaman"
                        title="Peminjaman">
                            <i class="bi bi-hand-index-thumb"></i>
                            <span>Peminjaman</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('pengembalian.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('pengembalian.*') ? 'active' : '' }}"
                        id="menu-pengembalian"
                        title="Pengembalian">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            <span>Pengembalian</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Laporan</div>
                <ul class="sidebar-menu-list">

                    <li class="sidebar-menu-item">
                        <a href="{{ route('laporan.inventaris') }}"
                        class="sidebar-menu-link {{ request()->routeIs('laporan.inventaris') ? 'active' : '' }}"
                        id="menu-lap-inventaris"
                        title="Laporan Inventaris">
                            <i class="bi bi-clipboard-data"></i>
                            <span>Laporan Inventaris</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('laporan.barang-masuk') }}"
                        class="sidebar-menu-link {{ request()->routeIs('laporan.barang-masuk') ? 'active' : '' }}"
                        id="menu-lap-masuk"
                        title="Laporan Barang Masuk">
                            <i class="bi bi-file-earmark-arrow-down"></i>
                            <span>Laporan Barang Masuk</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('laporan.barang-keluar') }}"
                        class="sidebar-menu-link {{ request()->routeIs('laporan.barang-keluar') ? 'active' : '' }}"
                        id="menu-lap-keluar"
                        title="Laporan Barang Keluar">
                            <i class="bi bi-file-earmark-arrow-up"></i>
                            <span>Laporan Barang Keluar</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('laporan.peminjaman') }}"
                        class="sidebar-menu-link {{ request()->routeIs('laporan.peminjaman') ? 'active' : '' }}"
                        id="menu-lap-peminjaman"
                        title="Laporan Peminjaman">
                            <i class="bi bi-file-earmark-person"></i>
                            <span>Laporan Peminjaman</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>

        <!-- Sidebar Profile Card (Dynamic Footer) -->
        <div class="sidebar-profile">
            <img src="{{ asset('assets/images/avatar.png')}}" alt="Administrator" class="sidebar-profile-img"
              >
            <div class="sidebar-profile-info">
                <div class="sidebar-profile-name">{{ Auth::user()->name ?? 'User' }}</div>
                <div class="sidebar-profile-email">{{ Auth::user()->email ?? 'admin@email.com' }}</div>
            </div>
        </div>
    </div>