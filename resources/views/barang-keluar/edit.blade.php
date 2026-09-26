@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Outgoing Item</h1>
        <p class="page-subtitle">Update the selected outgoing transaction</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Transaction' => '#',
        'Outgoing'    => route('barang-keluar.index'),
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
                <i class="bi bi-pencil-square text-warning"></i> Outgoing Information
            </h5>

            <form action="{{ route('barang-keluar.update', $data->id) }}" method="POST" id="barangKeluarForm">
                @csrf
                @method('PUT')

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
                            <option value="{{ $b->id }}" {{ old('item_id', $data->item_id) == $b->id ? 'selected' : '' }}>
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
                        <label for="tanggal_keluar" class="form-label-custom">
                            Outgoing Date <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               name="tanggal_keluar"
                               id="tanggal_keluar"
                               class="form-control-custom @error('tanggal_keluar') is-invalid-custom @enderror"
                               value="{{ old('tanggal_keluar', $data->tanggal_keluar) }}"
                               required>
                        @error('tanggal_keluar')
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
                               value="{{ old('jumlah', $data->jumlah) }}"
                               min="1"
                               required>
                        @error('jumlah')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @else
                            <span class="text-muted" style="font-size: 12px;">
                                Quantity changes will automatically adjust item stock.
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- =====================
                     Destination
                ====================== --}}
                <div class="mb-3">
                    <label for="tujuan" class="form-label-custom">Destination</label>
                    <input type="text"
                           name="tujuan"
                           id="tujuan"
                           class="form-control-custom @error('tujuan') is-invalid-custom @enderror"
                           value="{{ old('tujuan', $data->tujuan) }}"
                           placeholder="e.g. RPL Laboratory, Teacher Room, Student Loan">
                    @error('tujuan')
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
                              placeholder="Optional notes about this transaction...">{{ old('keterangan', $data->keterangan) }}</textarea>
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
                            <strong>#OUT-{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}</strong>
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
                    <a href="{{ route('barang-keluar.index') }}" class="btn-table-action">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn-table-action btn-primary-action">
                        <i class="bi bi-check-lg"></i> Update Outgoing
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
                    <div class="me-2" style="color:#ef4444;">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Stock auto-adjustment</div>
                        <div class="text-muted" style="font-size:12px;">
                            Changing quantity will <strong>reverse the old stock</strong> and apply the new amount.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#ef4444;">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Stock validation</div>
                        <div class="text-muted" style="font-size:12px;">
                            New quantity must not exceed available stock. The system will reject invalid input.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#f59e0b;">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Check before saving</div>
                        <div class="text-muted" style="font-size:12px;">
                            Make sure the date, quantity, and destination are correct.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#0ea5e9;">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Deleting transaction</div>
                        <div class="text-muted" style="font-size:12px;">
                            Deleting this transaction will <strong>restore</strong> the item stock.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-3 border-top">
                <a href="{{ route('barang-keluar.show', $data->id) }}"
                   class="text-decoration-none d-block mb-2"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-eye"></i> View transaction detail
                </a>
                <a href="{{ route('barang-keluar.index') }}"
                   class="text-decoration-none d-block"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-arrow-right"></i> View all outgoing
                </a>
            </div>
        </div>
    </div>
</div>
{{-- END: Form Card --}}

@endsection