@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Condition Data</h1>
        <p class="page-subtitle">Manage item conditions of SMK Informatika Utama Depok</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Master Data' => '#',
        'Condition'   => route('kondisi.index'),
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
     START: Table Card
     ========================================== --}}
<div class="table-card-custom">

    {{-- Header Controls --}}
    <div class="table-header-control justify-content-end">

        {{-- Action buttons --}}
        <div class="table-filter-group">
            
            <a href="{{ route('kondisi.create') }}" class="btn-table-action btn-primary-action">
                <i class="bi bi-plus-lg"></i> Add Condition
            </a>
        </div>
    </div>

    {{-- Responsive Table Wrapper --}}
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Condition Name</th>
                    <th>Status</th>
                    <th>Total Items</th>
                    <th>Created</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                    @php
                        $nama = strtolower($d->nama_kondisi);
                        $badgeClass = 'pending';
                        $statusLabel = 'Other';
                        $statusIcon = 'bi-circle';
                        if (strpos($nama, 'baik') !== false) {
                            $badgeClass = 'success';
                            $statusLabel = 'Good';
                            $statusIcon = 'bi-check-circle-fill';
                        } elseif (strpos($nama, 'ringan') !== false) {
                            $badgeClass = 'pending';
                            $statusLabel = 'Minor Damage';
                            $statusIcon = 'bi-exclamation-triangle-fill';
                        } elseif (strpos($nama, 'berat') !== false || strpos($nama, 'rusak') !== false) {
                            $badgeClass = 'failed';
                            $statusLabel = 'Major Damage';
                            $statusIcon = 'bi-x-circle-fill';
                        }
                    @endphp
                    <tr>
                        <td class="table-order-id">
                            {{ $data->firstItem() + $i }}
                        </td>
                        <td>
                            <div class="table-user-cell">
                                <div class="table-user-avatar"
                                     style="background:#22c55e;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                    <i class="bi bi-clipboard-check"></i>
                                </div>
                                <div>
                                    <div class="table-user-name">{{ $d->nama_kondisi }}</div>
                                    <div class="table-user-sub">
                                        ID: #CON-{{ str_pad($d->id, 3, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-table {{ $badgeClass }}">
                                <i class="bi {{ $statusIcon }}"></i> {{ $statusLabel }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-table success">
                                <i class="bi bi-box-seam"></i> {{ $d->items()->count() }} items
                            </span>
                        </td>
                        <td>{{ $d->created_at->translatedFormat('d M Y') }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('kondisi.show', $d->id) }}"
                                   class="table-btn-action"
                                   title="View details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('kondisi.edit', $d->id) }}"
                                   class="table-btn-action"
                                   title="Edit condition">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button"
                                        class="table-btn-action delete"
                                        title="Delete condition"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal"
                                        data-action="{{ route('kondisi.destroy', $d->id) }}"
                                        data-message="Delete condition '{{ $d->nama_kondisi }}'?">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted-green">
                                <i class="bi bi-inbox" style="font-size: 48px;"></i>
                                <p class="mt-2 mb-0">No condition data available.</p>
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
                of {{ $data->total() }} conditions
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