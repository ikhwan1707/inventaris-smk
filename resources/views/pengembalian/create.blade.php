@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Add Return</h1>
        <p class="page-subtitle">Record a loan return and update item condition</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Transaction' => '#',
        'Returns'     => route('pengembalian.index'),
        'Add'         => '',
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
                <i class="bi bi-arrow-counterclockwise text-success"></i> Return Information
            </h5>

            <form action="{{ route('pengembalian.store') }}" method="POST" id="pengembalianForm">
                @csrf

                {{-- =====================
                     Loan
                ====================== --}}
                <div class="mb-3">
                    <label for="loan_id" class="form-label-custom">
                        Loan <span class="text-danger">*</span>
                    </label>
                    <select name="loan_id"
                            id="loan_id"
                            class="form-select-custom @error('loan_id') is-invalid-custom @enderror"
                            required
                            autofocus>
                        <option value="">-- Select Loan --</option>
                        @foreach($peminjaman as $p)
                            <option value="{{ $p->id }}" {{ old('loan_id', $loan_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->kode_peminjaman }} — {{ $p->nama_peminjam }}
                                ({{ $p->item->nama_barang ?? '-' }} × {{ $p->jumlah }} {{ $p->item->satuan ?? '' }})
                            </option>
                        @endforeach
                    </select>
                    @error('loan_id')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @else
                        <span class="text-muted" style="font-size: 12px;">
                            Only shows loans with <strong>Borrowed</strong> status.
                        </span>
                    @enderror
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
                           value="{{ old('tanggal_kembali', date('Y-m-d')) }}"
                           required>
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
                        Item Condition on Return <span class="text-danger">*</span>
                    </label>
                    <select name="condition_id"
                            id="condition_id"
                            class="form-select-custom @error('condition_id') is-invalid-custom @enderror"
                            required>
                        <option value="">-- Select Condition --</option>
                        @foreach($kondisi as $k)
                            <option value="{{ $k->id }}" {{ old('condition_id') == $k->id ? 'selected' : '' }}>
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
                            Item condition in master data will be updated based on this selection.
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
                              placeholder="Optional notes about this return...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <hr class="my-4">

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('pengembalian.index') }}" class="btn-table-action">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn-table-action btn-primary-action">
                        <i class="bi bi-check-lg"></i> Save Return
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Stock will be restored</div>
                        <div class="text-muted" style="font-size:12px;">
                            Saving this return will <strong>add back</strong> the quantity to item stock.
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Status auto-update</div>
                        <div class="text-muted" style="font-size:12px;">
                            The loan status will automatically change to <strong>Returned</strong>.
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Condition matters</div>
                        <div class="text-muted" style="font-size:12px;">
                            Choose the actual item condition. It updates the master item record.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#0ea5e9;">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Only active loans</div>
                        <div class="text-muted" style="font-size:12px;">
                            Only loans with <strong>Borrowed</strong> status appear in the dropdown.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-3 border-top">
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