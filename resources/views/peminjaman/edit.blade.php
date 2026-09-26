@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Loan</h1>
        <p class="page-subtitle">Update loan information: {{ $data->kode_peminjaman }}</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Transaction' => '#',
        'Loans'       => route('peminjaman.index'),
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
                <i class="bi bi-pencil-square text-warning"></i> Loan Information
            </h5>

            <form action="{{ route('peminjaman.update', $data->id) }}" method="POST" id="peminjamanForm">
                @csrf
                @method('PUT')

                {{-- =====================
                     Loan Code (readonly)
                ====================== --}}
                <div class="mb-3">
                    <label class="form-label-custom">Loan Code</label>
                    <input type="text"
                           class="form-control-custom"
                           value="{{ $data->kode_peminjaman }}"
                           readonly
                           style="background:#f8f9fa;">
                    <span class="text-muted" style="font-size: 12px;">
                        Loan code cannot be changed.
                    </span>
                </div>

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
                     Borrower & Unit
                ====================== --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="nama_peminjam" class="form-label-custom">
                            Borrower Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="nama_peminjam"
                               id="nama_peminjam"
                               class="form-control-custom @error('nama_peminjam') is-invalid-custom @enderror"
                               value="{{ old('nama_peminjam', $data->nama_peminjam) }}"
                               placeholder="e.g. Budi Santoso"
                               required>
                        @error('nama_peminjam')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="kelas_atau_unit" class="form-label-custom">Class / Unit</label>
                        <input type="text"
                               name="kelas_atau_unit"
                               id="kelas_atau_unit"
                               class="form-control-custom @error('kelas_atau_unit') is-invalid-custom @enderror"
                               value="{{ old('kelas_atau_unit', $data->kelas_atau_unit) }}"
                               placeholder="e.g. XII RPL 1, Teacher, Staff">
                        @error('kelas_atau_unit')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- =====================
                     Dates
                ====================== --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="tanggal_pinjam" class="form-label-custom">
                            Loan Date <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               name="tanggal_pinjam"
                               id="tanggal_pinjam"
                               class="form-control-custom @error('tanggal_pinjam') is-invalid-custom @enderror"
                               value="{{ old('tanggal_pinjam', $data->tanggal_pinjam) }}"
                               required>
                        @error('tanggal_pinjam')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="rencana_kembali" class="form-label-custom">
                            Due Date <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               name="rencana_kembali"
                               id="rencana_kembali"
                               class="form-control-custom @error('rencana_kembali') is-invalid-custom @enderror"
                               value="{{ old('rencana_kembali', $data->rencana_kembali) }}"
                               required>
                        @error('rencana_kembali')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @else
                            <span class="text-muted" style="font-size: 12px;">
                                Must not be earlier than the loan date.
                            </span>
                        @enderror
                    </div>
                </div>

                {{-- =====================
                     Quantity
                ====================== --}}
                <div class="mb-3">
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

                {{-- =====================
                     Notes
                ====================== --}}
                <div class="mb-3">
                    <label for="keterangan" class="form-label-custom">Notes</label>
                    <textarea name="keterangan"
                              id="keterangan"
                              rows="3"
                              class="form-control-custom @error('keterangan') is-invalid-custom @enderror"
                              placeholder="Optional notes about this loan...">{{ old('keterangan', $data->keterangan) }}</textarea>
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
                            <strong>#LOAN-{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}</strong>
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
                    <a href="{{ route('peminjaman.index') }}" class="btn-table-action">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn-table-action btn-primary-action">
                        <i class="bi bi-check-lg"></i> Update Loan
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
                    <div class="me-2" style="color:#f59e0b;">
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
                    <div class="me-2" style="color:#f59e0b;">
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
                    <div class="me-2" style="color:#0ea5e9;">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Due date monitoring</div>
                        <div class="text-muted" style="font-size:12px;">
                            Overdue loans will be highlighted in the loan list.
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Cannot edit if returned</div>
                        <div class="text-muted" style="font-size:12px;">
                            Loans with <strong>Returned</strong> status cannot be edited.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-3 border-top">
                <a href="{{ route('peminjaman.show', $data->id) }}"
                   class="text-decoration-none d-block mb-2"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-eye"></i> View loan detail
                </a>
                <a href="{{ route('peminjaman.index') }}"
                   class="text-decoration-none d-block"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-arrow-right"></i> View all loans
                </a>
            </div>
        </div>
    </div>
</div>
{{-- END: Form Card --}}

@endsection