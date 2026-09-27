@extends('layouts.apps')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Search Results</h1>
        <p class="page-subtitle">
            @if($q)
                Showing results for "<strong>{{ $q }}</strong>" — {{ $total }} found
            @else
                Enter a keyword to search
            @endif
        </p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Search' => '',
    ]])
</div>

{{-- Empty state --}}
@if($q === '')
    <div class="card border-light shadow-sm p-5 text-center">
        <i class="bi bi-search" style="font-size: 64px; color: #adb5bd;"></i>
        <h5 class="mt-3">Start Searching</h5>
        <p class="text-muted">Type a keyword in the search bar above to find items, categories, locations, conditions, or loans.</p>
    </div>
@elseif($total === 0)
    <div class="card border-light shadow-sm p-5 text-center">
        <i class="bi bi-inbox" style="font-size: 64px; color: #adb5bd;"></i>
        <h5 class="mt-3">No Results</h5>
        <p class="text-muted">
            No results found for "<strong>{{ $q }}</strong>". Try a different keyword.
        </p>
    </div>
@else

    {{-- 1. ITEMS --}}
    @if($items->count() > 0)
        <div class="card border-light shadow-sm p-4 mb-3">
            <h5 class="card-title mb-3">
                <i class="bi bi-box-seam text-primary"></i>
                Items <span class="badge-table success ms-2">{{ $items->count() }}</span>
            </h5>
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Condition</th>
                            <th class="text-end">Qty</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $it)
                            <tr>
                                <td>
                                    <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                        {{ $it->kode_barang }}
                                    </span>
                                </td>
                                <td><strong>{{ $it->nama_barang }}</strong></td>
                                <td>{{ $it->category->nama_kategori ?? '-' }}</td>
                                <td>{{ $it->location->nama_ruangan ?? '-' }}</td>
                                <td>{{ $it->condition->nama_kondisi ?? '-' }}</td>
                                <td class="text-end">{{ $it->jumlah }} {{ $it->satuan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('barang.show', $it->id) }}" class="table-btn-action">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                <a href="{{ route('barang.index', ['keyword' => $q]) }}" class="small text-decoration-none">
                    View all items <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    @endif

    {{-- 2. CATEGORIES --}}
    @if($categories->count() > 0)
        <div class="card border-light shadow-sm p-4 mb-3">
            <h5 class="card-title mb-3">
                <i class="bi bi-tags text-success"></i>
                Categories <span class="badge-table success ms-2">{{ $categories->count() }}</span>
            </h5>
            <ul class="list-group list-group-flush">
                @foreach($categories as $c)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>{{ $c->nama_kategori }}</span>
                        <a href="{{ route('kategori.show', $c->id) }}" class="table-btn-action">
                            <i class="bi bi-eye"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="mt-2">
                <a href="{{ route('kategori.index', ['keyword' => $q]) }}" class="small text-decoration-none">
                    View all categories <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    @endif

    {{-- 3. LOCATIONS --}}
    @if($locations->count() > 0)
        <div class="card border-light shadow-sm p-4 mb-3">
            <h5 class="card-title mb-3">
                <i class="bi bi-door-open text-info"></i>
                Locations <span class="badge-table success ms-2">{{ $locations->count() }}</span>
            </h5>
            <ul class="list-group list-group-flush">
                @foreach($locations as $l)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>{{ $l->nama_ruangan }}</span>
                        <a href="{{ route('ruangan.show', $l->id) }}" class="table-btn-action">
                            <i class="bi bi-eye"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="mt-2">
                <a href="{{ route('ruangan.index', ['keyword' => $q]) }}" class="small text-decoration-none">
                    View all locations <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    @endif

    {{-- 4. CONDITIONS --}}
    @if($conditions->count() > 0)
        <div class="card border-light shadow-sm p-4 mb-3">
            <h5 class="card-title mb-3">
                <i class="bi bi-clipboard-check text-warning"></i>
                Conditions <span class="badge-table success ms-2">{{ $conditions->count() }}</span>
            </h5>
            <ul class="list-group list-group-flush">
                @foreach($conditions as $c)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>{{ $c->nama_kondisi }}</span>
                        <a href="{{ route('kondisi.show', $c->id) }}" class="table-btn-action">
                            <i class="bi bi-eye"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="mt-2">
                <a href="{{ route('kondisi.index', ['keyword' => $q]) }}" class="small text-decoration-none">
                    View all conditions <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    @endif

    {{-- 5. LOANS --}}
    @if($loans->count() > 0)
        <div class="card border-light shadow-sm p-4 mb-3">
            <h5 class="card-title mb-3">
                <i class="bi bi-hand-index-thumb text-warning"></i>
                Loans <span class="badge-table success ms-2">{{ $loans->count() }}</span>
            </h5>
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Item</th>
                            <th>Borrower</th>
                            <th>Loan Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $ln)
                            <tr>
                                <td>
                                    <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                        {{ $ln->kode_peminjaman }}
                                    </span>
                                </td>
                                <td>{{ $ln->item->nama_barang ?? '-' }}</td>
                                <td>
                                    {{ $ln->nama_peminjam }}
                                    @if($ln->kelas_atau_unit)
                                        <br><small class="text-muted">{{ $ln->kelas_atau_unit }}</small>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($ln->tanggal_pinjam)->format('d M Y') }}</td>
                                <td class="text-center">
                                    @if($ln->status == 'Dipinjam')
                                        <span class="badge-table pending">Borrowed</span>
                                    @else
                                        <span class="badge-table success">Returned</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('peminjaman.show', $ln->id) }}" class="table-btn-action">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                <a href="{{ route('peminjaman.index', ['keyword' => $q]) }}" class="small text-decoration-none">
                    View all loans <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    @endif

@endif

@endsection