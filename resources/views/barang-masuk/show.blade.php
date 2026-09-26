@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Incoming Detail</h1>
        <p class="page-subtitle">Transaction record: #IN-{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Transaction' => '#',
        'Incoming'    => route('barang-masuk.index'),
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
                <i class="bi bi-info-circle text-primary"></i> Transaction Information
            </h5>

            {{-- Detail Table --}}
            <div class="table-responsive">
                <table class="table-custom">
                    <tbody>
                        <tr>
                            <th width="220" style="background:#f8f9fa;">Transaction ID</th>
                            <td>
                                <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                    #IN-{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Incoming Date</th>
                            <td>
                                <i class="bi bi-calendar-event text-muted-green"></i>
                                {{ \Carbon\Carbon::parse($data->tanggal_masuk)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Item</th>
                            <td>
                                <div class="table-user-cell">
                                    <div class="table-user-avatar"
                                         style="background:#B4F105;color:#072F1F;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                        <i class="bi bi-box-arrow-in-down"></i>
                                    </div>
                                    <div>
                                        <div class="table-user-name">{{ $data->item->nama_barang ?? '-' }}</div>
                                        <div class="table-user-sub">
                                            Code: {{ $data->item->kode_barang ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Category</th>
                            <td>{{ $data->item->category->nama_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Location</th>
                            <td>
                                <i class="bi bi-geo-alt text-muted-green"></i>
                                {{ $data->item->location->nama_ruangan ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Quantity</th>
                            <td>
                                <span class="badge-table success">
                                    <i class="bi bi-plus-lg"></i>
                                    {{ $data->jumlah }} {{ $data->item->satuan ?? '' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Source</th>
                            <td>{{ $data->sumber ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Notes</th>
                            <td>{{ $data->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Recorded At</th>
                            <td>
                                <i class="bi bi-clock text-muted-green"></i>
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
                <a href="{{ route('barang-masuk.index') }}" class="btn-table-action">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('barang.show', $data->item_id ?? '#') }}"
                       class="btn-table-action"
                       style="background:#6366f1;color:#fff;">
                        <i class="bi bi-box-seam"></i> View Item
                    </a>
                    <a href="{{ route('barang-masuk.edit', $data->id) }}"
                       class="btn-table-action btn-primary-action">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <button type="button"
                            class="btn-table-action delete"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmDeleteModal"
                            data-action="{{ route('barang-masuk.destroy', $data->id) }}"
                            data-message="Delete this transaction? Item stock will be reduced by {{ $data->jumlah }} {{ $data->item->satuan ?? '' }}.">
                        <i class="bi bi-trash"></i> Delete
                    </button>
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
                    <div class="me-2" style="color:#B4F105;">
                        <i class="bi bi-arrow-up-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            +{{ $data->jumlah }} {{ $data->item->satuan ?? '' }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Stock added by this transaction.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#6366f1;">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->item->nama_barang ?? '-' }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Linked item information.
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
                            {{ $data->item->location->nama_ruangan ?? '-' }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Item stored location.
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
                            Transaction was recorded.
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
                            {{ $data->updated_at->diffForHumans() }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Last updated.
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info mb-0" style="font-size: 12px;">
                <i class="bi bi-info-circle-fill"></i>
                Deleting this transaction will <strong>reduce</strong> the item stock.
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