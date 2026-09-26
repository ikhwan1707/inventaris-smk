@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Return</h1>
        <p class="page-subtitle">Update return information: #RET-{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Transaction' => '#',
        'Returns'     => route('pengembalian.index'),
        'Edit'        => '',
    ]])
</div>
{{-- END: Page Header --}}


{{-- ==========================================
     START: Alert
     ========================================== --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- END: Alert --}}


{{-- ==========================================
     START: Form Card
     ========================================== --}}
<div class="row g-4 mb-4 justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-light shadow-sm p-4">

            <h5 class="card-title mb-4">
                <i class="bi bi-pencil-square text-warning"></i> Return Information
            </h5>

            <form action="{{ route('pengembalian.update', $data->id) }}" method="POST" id="pengembalianForm">
                @csrf
                @method('PUT')

                {{-- =====================
                     Loan (readonly)
                ====================== --}}
                <div class="mb-3">
                    <label class="form-label-custom">Loan</label>
                    <input type="text"
                           class="form-control-custom"
                           value="{{ $data->loan->kode_peminjaman ?? '-' }} — {{ $data->loan->nama_peminjam ?? '-' }}"
                           readonly
                           style="background:#f8f9fa;">
                    <span class="text-muted" style="font-size: 12px;">
                        Loan cannot be changed. To switch, delete this return first.
                    </span>
                </div>

                {{-- =====================
                     Item Info (readonly)
                ====================== --}}
                <div class="mb-3">
                    <label class="form-label-custom">Item</label>
                    <input type="text"
                           class="form-control-custom"
                           value="{{ $data->loan->item->kode_barang ?? '-' }} — {{ $data->loan->item->nama_barang ?? '-' }} ({{ $data->loan->jumlah ?? 0 }} {{ $data->loan->item->satuan ?? '' }})"
                           readonly
                           style="background:#f8f9fa;">
                </div>

                {{-- =====================
                     Return Date
                ====================== --}}
                <div class="mb-3">
                    <label for="tanggal_kembali" class="form-label-custom">
                        Return Date <span class="text-danger">*</span>
                    </label>
                    <input type="date"
                           name="tanggal_kembali"
                           id="tanggal_kembali"
                           class="form-control-custom @error('tanggal_kembali') is-invalid-custom @enderror"
                           value="{{ old('tanggal_kembali', $data->tanggal_kembali) }}"
                           required
                           autofocus>
                    @error('tanggal_kembali')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- =====================
                     Condition
                ====================== --}}
                <div class="mb-3">
                    <label for="condition_id" class="form-label-custom">
                        Item Condition <span class="text-danger">*</span>
                    </label>
                    <select name="condition_id"
                            id="condition_id"
                            class="form-select-custom @error('condition_id') is-invalid-custom @enderror"
                            required>
                        <option value="">-- Select Condition --</option>
                        @foreach($kondisi as $k)
                            <option value="{{ $k->id }}" {{ old('condition_id', $data->condition_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kondisi }}
                            </option>
                        @endforeach
                    </select>
                    @error('condition_id')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @else
                        <span class="text-muted" style="font-size: 12px;">
                            Item condition in master data will be updated automatically.
                        </span>
                    @enderror
                </div>

                {{-- =====================
                     Notes
                ====================== --}}
                <div class="mb-3">
                    <label for="keterangan" class="form-label-custom">Notes</label>
                    <textarea name="keterangan"
                              id="keterangan"
                              rows="3"
                              class="form-control-custom @error('keterangan') is-invalid-custom @enderror"
                              placeholder="Optional notes about this return...">{{ old('keterangan', $data->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- =====================
                     Metadata Info
                ====================== --}}
                <div class="mb-3">
                    <div class="d-flex gap-3 flex-wrap" style="font-size: 12px;">
                        <div class="text-muted">
                            <i class="bi bi-hash"></i> ID:
                            <strong>#RET-{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                        <div class="text-muted">
                            <i class="bi bi-calendar-plus"></i> Created:
                            <strong>{{ $data->created_at->translatedFormat('d M Y, H:i') }}</strong>
                        </div>
                        <div class="text-muted">
                            <i class="bi bi-clock-history"></i> Updated:
                            <strong>{{ $data->updated_at->translatedFormat('d M Y, H:i') }}</strong>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('pengembalian.index') }}" class="btn-table-action">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn-table-action btn-primary-action">
                        <i class="bi bi-check-lg"></i> Update Return
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Side Info Panel --}}
    <div class="col-12 col-lg-4">
        <div class="card border-light shadow-sm p-4 h-100">
            <h5 class="card-title mb-4">
                <i class="bi bi-info-circle text-primary"></i> Guidelines
            </h5>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#22c55e;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Loan is locked</div>
                        <div class="text-muted" style="font-size:12px;">
                            Loan and item cannot be changed. Delete the return first to select a different loan.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#22c55e;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Stock stays unchanged</div>
                        <div class="text-muted" style="font-size:12px;">
                            Editing this return does not change item stock.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#f59e0b;">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Condition update</div>
                        <div class="text-muted" style="font-size:12px;">
                            Changing the condition will update the item's condition in master data.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#ef4444;">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Deleting return</div>
                        <div class="text-muted" style="font-size:12px;">
                            Deleting this return will <strong>revert the loan</strong> to Borrowed status and reduce stock.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-3 border-top">
                <a href="{{ route('pengembalian.show', $data->id) }}"
                   class="text-decoration-none d-block mb-2"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-eye"></i> View return detail
                </a>
                <a href="{{ route('pengembalian.index') }}"
                   class="text-decoration-none d-block"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-arrow-right"></i> View all returns
                </a>
            </div>
        </div>
    </div>
</div>
{{-- END: Form Card --}}

@endsection