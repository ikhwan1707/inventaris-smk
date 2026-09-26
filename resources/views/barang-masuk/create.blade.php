@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Add Incoming Item</h1>
        <p class="page-subtitle">Record a new incoming transaction and update item stock</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Transaction' => '#',
        'Incoming'    => route('barang-masuk.index'),
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
                <i class="bi bi-box-arrow-in-down text-primary"></i> Incoming Information
            </h5>

            <form action="{{ route('barang-masuk.store') }}" method="POST" id="barangMasukForm">
                @csrf

                {{-- =====================
                     Item
                ====================== --}}
                <div class="mb-3">
                    <label for="item_id" class="form-label-custom">
                        Item <span class="text-danger">*</span>
                    </label>
                    <select name="item_id"
                            id="item_id"
                            class="form-select-custom @error('item_id') is-invalid-custom @enderror"
                            required
                            autofocus>
                        <option value="">-- Select Item --</option>
                        @foreach($barang as $b)
                            <option value="{{ $b->id }}" {{ old('item_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->kode_barang }} — {{ $b->nama_barang }}
                                (Stock: {{ $b->jumlah }} {{ $b->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('item_id')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- =====================
                     Date & Quantity
                ====================== --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="tanggal_masuk" class="form-label-custom">
                            Incoming Date <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               name="tanggal_masuk"
                               id="tanggal_masuk"
                               class="form-control-custom @error('tanggal_masuk') is-invalid-custom @enderror"
                               value="{{ old('tanggal_masuk', date('Y-m-d')) }}"
                               required>
                        @error('tanggal_masuk')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="jumlah" class="form-label-custom">
                            Quantity <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               name="jumlah"
                               id="jumlah"
                               class="form-control-custom @error('jumlah') is-invalid-custom @enderror"
                               value="{{ old('jumlah', 1) }}"
                               min="1"
                               required>
                        @error('jumlah')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @else
                            <span class="text-muted" style="font-size: 12px;">
                                Item stock will increase by this amount.
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- =====================
                     Source
                ====================== --}}
                <div class="mb-3">
                    <label for="sumber" class="form-label-custom">Source</label>
                    <input type="text"
                           name="sumber"
                           id="sumber"
                           class="form-control-custom @error('sumber') is-invalid-custom @enderror"
                           value="{{ old('sumber') }}"
                           placeholder="e.g. Purchase, Donation, Government Aid">
                    @error('sumber')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
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
                              placeholder="Optional notes about this transaction...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <hr class="my-4">

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('barang-masuk.index') }}" class="btn-table-action">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn-table-action btn-primary-action">
                        <i class="bi bi-check-lg"></i> Save Incoming
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
                    <div class="me-2" style="color:#B4F105;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Stock will increase</div>
                        <div class="text-muted" style="font-size:12px;">
                            Saving this transaction will <strong>add</strong> the quantity to item stock.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#B4F105;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Correct item selection</div>
                        <div class="text-muted" style="font-size:12px;">
                            Make sure to select the correct item before saving.
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Accurate date</div>
                        <div class="text-muted" style="font-size:12px;">
                            Use the actual incoming date for accurate reporting.
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Stock corrections</div>
                        <div class="text-muted" style="font-size:12px;">
                            For corrections, edit the transaction instead of creating a new one.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-3 border-top">
                <a href="{{ route('barang-masuk.index') }}"
                   class="text-decoration-none d-block"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-arrow-right"></i> View all incoming
                </a>
            </div>
        </div>
    </div>
</div>
{{-- END: Form Card --}}

@endsection