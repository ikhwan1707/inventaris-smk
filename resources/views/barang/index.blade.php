@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Item Data</h1>
        <p class="page-subtitle">Manage inventory items of SMK Informatika Utama Depok</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Master Data' => '#',
        'Item'        => route('barang.index'),
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
     START: Filter Card
     ========================================== --}}
<div class="card border-light shadow-sm p-3 mb-3">
    <form method="GET" action="{{ route('barang.index') }}">
        <div class="row g-2 align-items-end">

            {{-- Keyword --}}
            <div class="col-12 col-md-3">
                <label class="form-label-custom" style="font-size:12px;">Search</label>
                <input type="text"
                       name="keyword"
                       class="form-control-custom"
                       placeholder="Search code or name..."
                       value="{{ request('keyword') }}">
            </div>

            {{-- Category --}}
            <div class="col-12 col-md-2">
                <label class="form-label-custom" style="font-size:12px;">Category</label>
                <select name="category_id" class="form-select-custom">
                    <option value="">-- All --</option>
                    @foreach(\App\Category::orderBy('nama_kategori')->get() as $k)
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
                    @foreach(\App\Location::orderBy('nama_ruangan')->get() as $r)
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
                    @foreach(\App\Condition::orderBy('nama_kondisi')->get() as $c)
                        <option value="{{ $c->id }}" {{ request('condition_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->nama_kondisi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Buttons --}}
            <div class="col-12 col-md-3">
                <button type="submit" class="btn-table-action btn-primary-action">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('barang.index') }}" class="btn-table-action">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>

        </div>
    </form>
</div>
{{-- END: Filter Card --}}


{{-- ==========================================
     START: Table Card
     ========================================== --}}
<div class="table-card-custom">

    {{-- Header Controls --}}
    <div class="table-header-control justify-content-end">
        <div class="table-filter-group">
            <a href="{{ route('barang.create') }}" class="btn-table-action btn-primary-action">
                <i class="bi bi-plus-lg"></i> Add Item
            </a>
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
                    <th class="text-center">Actions</th>
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
                        <td class="table-order-id">{{ $data->firstItem() + $i }}</td>
                        <td>
                            <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                {{ $d->kode_barang }}
                            </span>
                        </td>
                        
                        <td>
                            <div class="table-user-cell">
                                <div class="table-user-avatar" style="background:#6366f1;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;;">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div>
                                    <div class="table-user-name">
                                        {{ $d->nama_barang }}
                                        @if(str_contains($d->kode_barang, '-R'))
                                        <span class="badge-table pending" style="font-size:10px;">Variant</span>
                                        @endif
                                    </div>
                                    <div class="table-user-sub">
                                        ID: #ITM-{{ str_pad($d->id, 3, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $d->category->nama_kategori ?? '-' }}</td>
                        <td>{{ $d->location->nama_ruangan ?? '-' }}</td>
                        <td>
                            <span class="badge-table {{ $badgeClass }}">
                                <i class="bi {{ $statusIcon }}"></i> {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="text-end">
                            <strong>{{ $d->jumlah }}</strong>
                            <span class="text-muted" style="font-size:12px;">{{ $d->satuan }}</span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('barang.show', $d->id) }}"
                                   class="table-btn-action"
                                   title="View details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('barang.edit', $d->id) }}"
                                   class="table-btn-action"
                                   title="Edit item">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button"
                                        class="table-btn-action delete"
                                        title="Delete item"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal"
                                        data-action="{{ route('barang.destroy', $d->id) }}"
                                        data-message="Delete item '{{ $d->nama_barang }}'?">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted-green">
                                <i class="bi bi-inbox" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">No item data available.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer / Pagination --}}
    @if($data->count() > 0)
        <div class="table-footer-control">
            <span class="table-pagination-info">
                Showing {{ $data->firstItem() }}–{{ $data->lastItem() }}
                of {{ $data->total() }} items
            </span>
            <nav aria-label="Page navigation">
                {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}
            </nav>
        </div>
    @endif

</div>
{{-- END: Table Card --}}


{{-- ==========================================
     Modal Confirmation Delete
     ========================================== --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:#B4F105;color:#B4F105;">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle"></i> Delete Confirmation
                </h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="confirmDeleteMessage" class="mb-0">
                    Are you sure you want to delete this data?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-table-action" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Cancel
                </button>
                <form id="confirmDeleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-table-action delete">
                        <i class="bi bi-trash"></i> Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('confirmDeleteModal');
    if (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            const button  = event.relatedTarget;
            const action  = button.getAttribute('data-action');
            const message = button.getAttribute('data-message') || 'Are you sure you want to delete this data?';

            document.getElementById('confirmDeleteForm').setAttribute('action', action);
            document.getElementById('confirmDeleteMessage').textContent = message;
        });
    }
});
</script>
@endpush