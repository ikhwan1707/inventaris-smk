@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Loan Detail</h1>
        <p class="page-subtitle">Loan record: {{ $data->kode_peminjaman }}</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Transaction' => '#',
        'Loans'       => route('peminjaman.index'),
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

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle text-primary"></i> Loan Information
                </h5>
                @if($data->status == 'Dipinjam')
                    <span class="badge-table pending">
                        <i class="bi bi-hourglass-split"></i> Borrowed
                    </span>
                @else
                    <span class="badge-table success">
                        <i class="bi bi-check-circle-fill"></i> Returned
                    </span>
                @endif
            </div>

            @php
                $terlambat = $data->status == 'Dipinjam'
                    && \Carbon\Carbon::parse($data->rencana_kembali)->isPast();
            @endphp

            {{-- Detail Table --}}
            <div class="table-responsive">
                <table class="table-custom">
                    <tbody>
                        <tr>
                            <th width="220" style="background:#f8f9fa;">Loan Code</th>
                            <td>
                                <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                    {{ $data->kode_peminjaman }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Status</th>
                            <td>
                                @if($data->status == 'Dipinjam')
                                    <span class="badge-table pending">
                                        <i class="bi bi-hourglass-split"></i> Borrowed
                                    </span>
                                @else
                                    <span class="badge-table success">
                                        <i class="bi bi-check-circle-fill"></i> Returned
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Item</th>
                            <td>
                                <div class="table-user-cell">
                                    <div class="table-user-avatar"
                                         style="background:#f59e0b;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                        <i class="bi bi-hand-index-thumb"></i>
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
                                <span class="badge-table pending">
                                    {{ $data->jumlah }} {{ $data->item->satuan ?? '' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Borrower</th>
                            <td><strong>{{ $data->nama_peminjam }}</strong></td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Class / Unit</th>
                            <td>{{ $data->kelas_atau_unit ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Loan Date</th>
                            <td>
                                <i class="bi bi-calendar-event text-muted-green"></i>
                                {{ \Carbon\Carbon::parse($data->tanggal_pinjam)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Due Date</th>
                            <td>
                                <i class="bi bi-calendar-check text-muted-green"></i>
                                {{ \Carbon\Carbon::parse($data->rencana_kembali)->translatedFormat('d F Y') }}

                                @if($terlambat)
                                    <span class="badge-table failed ml-2">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                        Overdue ({{ \Carbon\Carbon::parse($data->rencana_kembali)->diffForHumans() }})
                                    </span>
                                @endif
                            </td>
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

            {{-- Return History --}}
            <h5 class="card-title mt-4 mb-3">
                <i class="bi bi-clock-history text-primary"></i> Return History
            </h5>

            @if($data->returns->count() > 0)
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Return Date</th>
                                <th>Condition</th>
                                <th>Notes</th>
                                <th>Recorded</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->returns as $i => $r)
                                @php
                                    $namaKondisi = $r->condition->nama_kondisi ?? '-';
                                    $badgeClass = 'pending';
                                    $statusIcon = 'bi-circle';
                                    if (stripos($namaKondisi, 'baik') !== false) {
                                        $badgeClass = 'success';
                                        $statusIcon = 'bi-check-circle-fill';
                                    } elseif (stripos($namaKondisi, 'ringan') !== false) {
                                        $badgeClass = 'pending';
                                        $statusIcon = 'bi-exclamation-triangle-fill';
                                    } elseif (stripos($namaKondisi, 'berat') !== false || stripos($namaKondisi, 'rusak') !== false) {
                                        $badgeClass = 'failed';
                                        $statusIcon = 'bi-x-circle-fill';
                                    }
                                @endphp
                                <tr>
                                    <td class="table-order-id">{{ $i + 1 }}</td>
                                    <td>
                                        <i class="bi bi-calendar-check text-muted-green"></i>
                                        {{ \Carbon\Carbon::parse($r->tanggal_kembali)->translatedFormat('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="badge-table {{ $badgeClass }}">
                                            <i class="bi {{ $statusIcon }}"></i> {{ $namaKondisi }}
                                        </span>
                                    </td>
                                    <td>{{ $r->keterangan ?? '-' }}</td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $r->created_at->translatedFormat('d M Y, H:i') }}
                                        </small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0" style="font-size: 13px;">
                    <i class="bi bi-info-circle-fill"></i>
                    No return history for this loan yet.
                </div>
            @endif

            <hr class="my-4">

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <a href="{{ route('peminjaman.index') }}" class="btn-table-action">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <div class="d-flex gap-2 flex-wrap">
                    @if($data->status == 'Dipinjam')
                        <a href="{{ route('pengembalian.create', ['loan_id' => $data->id]) }}"
                           class="btn-table-action"
                           style="background:#22c55e;color:#fff;">
                            <i class="bi bi-arrow-counterclockwise"></i> Process Return
                        </a>
                        <a href="{{ route('peminjaman.edit', $data->id) }}"
                           class="btn-table-action btn-primary-action">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button"
                                class="btn-table-action delete"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal"
                                data-action="{{ route('peminjaman.destroy', $data->id) }}"
                                data-message="Delete loan '{{ $data->kode_peminjaman }}'? Item stock will be restored by {{ $data->jumlah }} {{ $data->item->satuan ?? '' }}.">
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
                    <div class="me-2" style="color:#f59e0b;">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->status == 'Dipinjam' ? 'Currently Borrowed' : 'Already Returned' }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Loan status.
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
                            Borrowed item.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#0ea5e9;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->nama_peminjam }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            {{ $data->kelas_atau_unit ?? 'Borrower' }}
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
                            {{ \Carbon\Carbon::parse($data->rencana_kembali)->diffForHumans() }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Due date.
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
                            Loan was recorded.
                        </div>
                    </div>
                </div>
            </div>

            @if($terlambat)
                <div class="alert alert-danger mb-0" style="font-size: 12px;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Overdue!</strong> This loan has passed its due date.
                </div>
            @elseif($data->status == 'Dipinjam')
                <div class="alert alert-info mb-0" style="font-size: 12px;">
                    <i class="bi bi-info-circle-fill"></i>
                    Use <strong>Process Return</strong> when the item is returned.
                </div>
            @else
                <div class="alert alert-success mb-0" style="font-size: 12px;">
                    <i class="bi bi-check-circle-fill"></i>
                    This loan has been completed.
                </div>
            @endif
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