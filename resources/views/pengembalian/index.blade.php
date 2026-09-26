@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Return Data</h1>
        <p class="page-subtitle">Manage item returns of SMK Informatika Utama Depok</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Transaction' => '#',
        'Returns'     => route('pengembalian.index'),
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
    <form method="GET" action="{{ route('pengembalian.index') }}">
        <div class="row g-2 align-items-end">

            {{-- Start Date --}}
            <div class="col-12 col-md-3">
                <label class="form-label-custom" style="font-size:12px;">From Date</label>
                <input type="date"
                       name="tanggal_awal"
                       class="form-control-custom"
                       value="{{ request('tanggal_awal') }}">
            </div>

            {{-- End Date --}}
            <div class="col-12 col-md-3">
                <label class="form-label-custom" style="font-size:12px;">To Date</label>
                <input type="date"
                       name="tanggal_akhir"
                       class="form-control-custom"
                       value="{{ request('tanggal_akhir') }}">
            </div>

            {{-- Condition --}}
            <div class="col-12 col-md-3">
                <label class="form-label-custom" style="font-size:12px;">Condition</label>
                <select name="condition_id" class="form-select-custom">
                    <option value="">-- All Conditions --</option>
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
                <a href="{{ route('pengembalian.index') }}" class="btn-table-action">
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
            <a href="{{ route('pengembalian.create') }}" class="btn-table-action btn-primary-action">
                <i class="bi bi-plus-lg"></i> Add Return
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Loan Code</th>
                    <th>Item</th>
                    <th>Borrower</th>
                    <th class="text-end">Quantity</th>
                    <th>Return Date</th>
                    <th>Final Condition</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                    @php
                        $namaKondisi = $d->condition->nama_kondisi ?? '-';
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
                        <td class="table-order-id">{{ $data->firstItem() + $i }}</td>
                        <td>
                            <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                {{ $d->loan->kode_peminjaman ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="table-user-cell">
                                <div class="table-user-avatar"
                                     style="background:#22c55e;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </div>
                                <div>
                                    <div class="table-user-name">{{ $d->loan->item->nama_barang ?? '-' }}</div>
                                    <div class="table-user-sub">
                                        ID: #RET-{{ str_pad($d->id, 5, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $d->loan->nama_peminjam ?? '-' }}</strong>
                            @if($d->loan->kelas_atau_unit)
                                <br><small class="text-muted">{{ $d->loan->kelas_atau_unit }}</small>
                            @endif
                        </td>
                        <td class="text-end">
                            <span class="badge-table success">
                                {{ $d->loan->jumlah ?? 0 }} {{ $d->loan->item->satuan ?? '' }}
                            </span>
                        </td>
                        <td>
                            <i class="bi bi-calendar-check text-muted-green"></i>
                            {{ \Carbon\Carbon::parse($d->tanggal_kembali)->format('d M Y') }}
                        </td>
                        <td>
                            <span class="badge-table {{ $badgeClass }}">
                                <i class="bi {{ $statusIcon }}"></i> {{ $namaKondisi }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('pengembalian.show', $d->id) }}"
                                   class="table-btn-action"
                                   title="View details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('pengembalian.edit', $d->id) }}"
                                   class="table-btn-action"
                                   title="Edit return">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button"
                                        class="table-btn-action delete"
                                        title="Delete return"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal"
                                        data-action="{{ route('pengembalian.destroy', $d->id) }}"
                                        data-message="Cancel this return? Loan '{{ $d->loan->kode_peminjaman ?? '-' }}' will be reverted to Borrowed status.">
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
                                <p class="mt-2 mb-0">No return data available.</p>
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
                of {{ $data->total() }} returns
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