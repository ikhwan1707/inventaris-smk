@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Location Detail</h1>
        <p class="page-subtitle">Detailed information of {{ $data->nama_ruangan }}</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Master Data' => '#',
        'Location'    => route('ruangan.index'),
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
                <i class="bi bi-info-circle text-primary"></i> Location Information
            </h5>

            {{-- Detail Table --}}
            <div class="table-responsive">
                <table class="table-custom">
                    <tbody>
                        <tr>
                            <th width="220" style="background:#f8f9fa;">Location Name</th>
                            <td>
                                <div class="table-user-cell">
                                    <div class="table-user-avatar"
                                         style="background:#0ea5e9;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                        <i class="bi bi-door-open"></i>
                                    </div>
                                    <div>
                                        <div class="table-user-name">{{ $data->nama_ruangan }}</div>
                                        <div class="table-user-sub">
                                            ID: #LOC-{{ str_pad($data->id, 3, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
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
                        <tr>
                            <th style="background:#f8f9fa;">Linked Items</th>
                            <td>
                                <span class="badge-table {{ $data->items()->count() > 0 ? 'success' : 'pending' }}">
                                    <i class="bi bi-box-seam"></i>
                                    {{ $data->items()->count() }} items
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr class="my-4">

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <a href="{{ route('ruangan.index') }}" class="btn-table-action">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('ruangan.edit', $data->id) }}"
                       class="btn-table-action btn-primary-action">
                        <i class="bi bi-pencil"></i> Edit Location
                    </a>
                    @if($data->items()->count() == 0)
                        <button type="button"
                                class="btn-table-action delete"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal"
                                data-action="{{ route('ruangan.destroy', $data->id) }}"
                                data-message="Delete location '{{ $data->nama_ruangan }}'?">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    @endif
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
                    <div class="me-2" style="color:#0ea5e9;">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->items()->count() }} Items
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Total items stored in this location.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#22c55e;">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->created_at->diffForHumans() }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Location was first created.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#f59e0b;">
                        <i class="bi bi-pencil-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->updated_at->diffForHumans() }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Last time this location was updated.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-3 border-top">
                <a href="{{ route('barang.index', ['location_id' => $data->id]) }}"
                   class="text-decoration-none"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-arrow-right"></i> View items in this location
                </a>
            </div>
        </div>
    </div>
</div>
{{-- END: Detail Card --}}


{{-- ==========================================
     Modal Confirmation Delete
     ========================================== --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:#072F1F;color:#B4F105;">
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